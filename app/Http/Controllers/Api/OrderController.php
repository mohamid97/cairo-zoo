<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderGuestRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\Admin\OrderAuthResource;
use App\Models\Admin\City;
use App\Models\Admin\Coupon;
use App\Models\Admin\OrderAddress;
use App\Models\Admin\OrderInfo;
use App\Models\Admin\Points;
use App\Models\Admin\PointsPrice;
use App\Models\Admin\Product;
use App\Models\Admin\Shimpment;
use App\Models\Admin\ShimpmentZone;
use App\Models\Front\Card;
use App\Models\Front\Order;
use App\Models\Front\OrderItem;
use App\Trait\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ResponseTrait;
    // store order
    public function store_auth(StoreOrderRequest $request){

        DB::beginTransaction();
        try {
            $user = $request->user();

            if ($request->has('coupon_code')) {
                $coupon = Coupon::where('code', $request->input('coupon_code'))->where('is_active' , 1)->whereDate('start_date', '<=', Carbon::now())
                ->whereDate('end_date', '>=', Carbon::now())->first();
                if (!$coupon) {
                    return $this->res(false, __('main.invalid_coupon_code'), 400);
                }
                if ($coupon->times_used >= $coupon->usage_limit) {
                    return $this->res(false, __('main.coupon_limit'), 400);

                }
            }


            $check_order = Order::where('user_id' , $user->id)->where('status' , 'pending')->first();
            if(isset($check_order)){
                return $this->res(false , __('main.have_pending_order') , 422);
            }
            $cart = $this->getCartItems($user->id);
            if (empty($cart->items)) {
                return $this->res(false , __('main.empty_cart'), 400);
            }

            $cartItems = $cart->items;
            $totalbeforePrice = $cartItems->sum(function ($item) {
                return Product::find($item->product_id)->sales_price * $item->quantity;
            });

            $totalAfterPrice = $cartItems->sum(function ($item) {
                $discount = Product::find($item->product_id)->getBestDiscount();
                $discount_value = $discount['value'] ?? 0;
                $discount_type = $discount['type'] ?? null;
                return ( Product::find($item->product_id)->sales_price - $discount_value ) * $item->quantity;
            });





            if (isset($coupon)) {
                $coupon_discount = $coupon->type == 'percentage' ? ceil($totalAfterPrice * $coupon->discount) / 100 : ceil($coupon->discount);
                $totalAfterPrice -= $coupon_discount;
            }

            // check points
            if($request->points && $user->points >= $request->points){
                $pointPrice = PointsPrice::first();
                if(isset($pointPrice)){
                   $all_pounds = floor(($request->points / $pointPrice->num_points) * $pointPrice->num_pounds);
                   $pounds = ($all_pounds <= $totalAfterPrice) ? $all_pounds : $totalAfterPrice;
                   $totalAfterPrice -= $pounds;
                   $user->points -= $request->points;
                   $user->pounds -= $all_pounds;
                   $user->save();
                }




            }

            $ship_details = $this->get_shipment_price($request->shipment_way ?? 'delivery' , $request->zone_id , $request->city_id , ceil($totalAfterPrice));

            $order = Order::create([
                'user_id' => $user->id,
                'total_price_after_discount' => ceil($totalAfterPrice),
                'total_price_before_discount' => ceil($totalbeforePrice),
                'shipment_price' => ceil($ship_details['price'])  ?? 0,
                'payment_method' => $request->input('payment_method', 'cash'),
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'phone'=>$request->phone,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'coupon_code' => $request->input('coupon_code') ?? null,
                'coupon_discount' =>(isset($coupon)) ? ceil($coupon_discount) : null,
                'discount_type' => (isset($coupon)) ? $coupon->type : null,
                'zone'=>$ship_details['zone_name'] ?? 'N/A',
                'city'=>$ship_details['city_name'] ?? 'N/A',
                'points_used' => $request->points ?? 0,
                'pounds_used' => (isset($pounds)) ? $pounds : 0


            ]);

            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem->product_id);
                if ($product->stock < $cartItem->quantity) {
                    return $this->res(false , __('main.stock_less_than_quantity') . ' : ' .  $product->name , 402);

                }
                $product->stock -= $cartItem->quantity;
                $order_info = $product->deductStock($cartItem->quantity);
                $this->order_info($order->id , $product->id , $order_info);

                // dd(ceil($cartItem->product->getBestDiscount()['value'] ?? 0));

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'sales_price' => ceil($cartItem->product->sales_price * $cartItem->quantity),
                    'discount'=> ceil($cartItem->product->getBestDiscount()['value'] ?? 0),
                    'price'=> ceil(( $cartItem->product->sales_price - ($cartItem->product->getBestDiscount()['value'] ?? 0 )  ) * $cartItem->quantity)
                ]);


                $product->save();
            }
            if ($request->has('address')) {
                OrderAddress::create([
                    'order_id'=>$order->id,
                    'address' => $request->input('address'),
                ]);
            }





            DB::commit();
            $this->clearCart($user->id);
            $order = Order::with(['items' ,'address' ,'user'])->where('user_id' , $user->id)->first();
            return $this->res(true , __('main.order_updated_successfully') , 200 , new OrderAuthResource( $order ));

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->res(false , $e->getMessage() , 500 , $e->getLine());
        }









    } // end order




    // ship fun return price and city and zone name
    private function get_shipment_price($ship_way , $zone_id , $city_id , $total_price){
            $zone = ShimpmentZone::find($zone_id);
            $city = City::find($city_id);
        if($ship_way && $ship_way != 'store') {
            $shipment_setting = Shimpment::first();
            if(isset($shipment_setting) && $shipment_setting->is_free != 'free' && $total_price < $shipment_setting->min_to_free){

                return [ 'price'=>$zone->price , 'zone_name'=>$zone->name , 'city_name'=>$city->name  ];

            }


        }


        return [ 'price'=>0 , 'zone_name'=>$zone->name , 'city_name'=>$city->name  ];


    }

    private function order_info($order_id , $product_id , $order_info){

        foreach($order_info as $info){
            OrderInfo::create([
                'order_id'=>$order_id,
                'product_id'=>$product_id,
                'qty'=>$info['qty'],
                'sales_price'=>$info['sales_price'],
                'cost_price'=>$info['cost_price']
            ]);
        }

    }


    private function getCartItems($userId)
    {
        return Card::with('items')->where('user_id', $userId)->first();
    } //end getCartItems

    private function clearCart($userId)
    {        Card::where('user_id', $userId)->delete();
    }










    // public function deleteOrder(Request $request)
    // {
    //     // Start transaction to ensure all related data is deleted or nothing at all
    //     DB::beginTransaction();

    //     try {
    //         // Retrieve the order by its ID, ensuring it belongs to the authenticated user
    //         $order = Order::where('id', $request->order_id)->where('user_id', $request->user()->id )->first();

    //         if (!$order) {
    //             return $this->res(false , 'Order not found or does not belong to you' , 404);

    //         }

    //         // Check if the order status is 'pending'
    //         if ($order->status !== 'pending') {
    //             return response()->json(['error' => 'Only pending orders can be deleted'], 403);
    //         }
    //         // Delete related order items
    //         $order->items()->delete();

    //         // Delete the order
    //         $order->delete();

    //         // Commit the transaction
    //         DB::commit();

    //         return $this->res(true , 'Order Deleted Successfully!' , 200);
    //     } catch (\Exception $e) {
    //         // Rollback the transaction if something fails
    //         DB::rollBack();
    //         return $this->res(true , $e->getMessage() , 500);
    //     }
    // }





    public function store_guest(StoreOrderGuestRequest $request){


        DB::beginTransaction();
        try {

            $coupon = null;
                if ($request->has('coupon_code')) {
                    $coupon = Coupon::where('code', $request->input('coupon_code'))->where('is_active' , 1)->whereDate('start_date', '<=', Carbon::now())
                    ->whereDate('end_date', '>=', Carbon::now())->first();
                    if (!$coupon) {
                        return $this->res(false, __('main.invalid_coupon_code'), 400);
                    }
                    if ($coupon->times_used >= $coupon->usage_limit) {
                        return $this->res(false, __('main.coupon_limit'), 400);

                    }
                }

                $totalBefore = 0;
                $totalAfter = 0;
                foreach ($request->products as $item) {
                    $product = Product::find($item['id']);

                    if (!isset($product)) {
                        return $this->res(false, __('main.product_not_found'), 404);
                    }

                    if ($product->stock < $item['quantity']) {
                        return $this->res(false, __('main.stock_less_than_quantity') . ': ' . $product->name, 402);
                    }

                    $discount = $product->getBestDiscount();
                    $discountValue = $discount['value'] ?? 0;

                    $before = $product->sales_price * $item['quantity'];
                    $after = ($product->sales_price - $discountValue) * $item['quantity'];

                    $totalBefore += $before;
                    $totalAfter += $after;

                    $items[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'price' => $after,
                        'discount' => $discountValue
                    ];
                }



                $couponDiscount = 0;
                if (isset($coupon)) {
                    $couponDiscount = $coupon->type == 'percentage'
                        ? ceil($totalAfter * $coupon->discount / 100)
                        : ceil($coupon->discount);

                    $totalAfter -= $couponDiscount;
                }


               $ship_details = $this->get_shipment_price($request->shipment_way ?? 'delivery' , $request->zone_id , $request->city_id , ceil($totalAfter));



                $order = Order::create([
                    'user_id' => null,
                    'total_price_before_discount' => ceil($totalBefore),
                    'total_price_after_discount' => ceil($totalAfter),
                    'shipment_price' => ceil($ship_details['price'])  ?? 0,
                    'payment_method' => $request->input('payment_method', 'cash'),
                    'payment_status' => 'unpaid',
                    'status' => 'pending',
                    'phone' => $request->phone,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'coupon_code' => $request->input('coupon_code') ?? null,
                    'coupon_discount' =>(isset($coupon)) ? ceil($couponDiscount) : null,
                    'discount_type' => (isset($coupon)) ? $coupon->type : null,
                    'zone' => $ship_details['zone_name'] ?? 'N/A',
                    'city' => $ship_details['city_name'] ?? 'N/A'
                ]);


                foreach ($items as $item) {
                    $product = $item['product'];
                    $product->stock -= $item['quantity'];
                    $order_info = $product->deductStock($item['quantity']);
                    $this->order_info($order->id , $product->id , $order_info);
                    $product->save();

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $item['quantity'],
                        'sales_price' => $product->sales_price * $item['quantity'],
                        'discount' => $item['discount'],
                        'price' => $item['price']
                    ]);
                }

            if ($request->has('address')) {
                OrderAddress::create([
                    'order_id'=>$order->id,
                    'address' => $request->input('address'),
                ]);
            }


                DB::commit();
                // Return the created order with its details
                return $this->res(true , __('main.order_added_successfully') , 200);

        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollBack();
            return $this->res(true , $e->getMessage() , 500);

        }




    } // end guest store order




    public function get_user_orders(Request $request){
        $user = $request->user();
        $orders = Order::with(['items' , 'address' ,'address' ,'user'])->where('user_id' , $user->id)->paginate(15); // Paginate with 10 items per page;
        // Return the created order with its details
        return $this->res(true , __('main.all_user_order') , 200 ,  ['orders' => OrderAuthResource::collection( $orders ) ,
           'pagination' => [
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage(),
            'per_page' => $orders->perPage(),
            'total' => $orders->total(),
            'next_page_url' => $orders->nextPageUrl(),
            'prev_page_url' => $orders->previousPageUrl(),
         ]
       ]);


    } //end get_user_ordes














}
