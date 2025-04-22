<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrderGuestRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\Admin\OrderAuthResource;
use App\Models\Admin\OrderAddress;
use App\Models\Admin\Product;
use App\Models\Front\Card;
use App\Models\Front\Order;
use App\Models\Front\OrderItem;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ResponseTrait;
    // store order
    public function store_auth(StoreOrderRequest $request){
     
        // Start transaction to ensure everything is done or rolled back
        DB::beginTransaction(); 
        try {
            // Retrieve user ID from the authenticated user
            $user = $request->user();
            //check if have pending order
            $check_order = Order::where('user_id' , $user->id)->where('status' , 'pending')->first();
            if(isset($check_order)){
                return $this->res(false , 'You Already Have Order In Pending' , 422);
            }
            // Retrieve cart data (this could be a service or direct access to the cart model)
            $cart = $this->getCartItems($user->id);
            if (empty($cart->items)) {
                return $this->res(false , 'Card Is Empty' , 400);
            }

            $cartItems = $cart->items;
            // Calculate total price
            $totalPrice = $cartItems->sum(function ($item) {
                return Product::find($item->product_id)->price * $item->quantity;
            });
            $total_ship = 0;
            // Create the order items
            if($request->has('shipment_way') && $request->shipment_way == 'store'){
                $total_ship = 0;
            }else{
                foreach ($cartItems as $cartItem) {
                    $total_ship += 50;
     
                }
            }
            // Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'shipment_price' => $total_ship, // Default shipment price can be 0
                'payment_method' => $request->input('payment_method', 'cash'),
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'phone'=>$request->phone,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name
            ]);

            // Create the order items
            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem->product_id);
            
                // Ensure there is enough stock before proceeding
                if ($product->stock < $cartItem->quantity) {
                    return $this->res(false , 'Not enough stock for product: ' . $product->name , 402);
                    
                }
    
                // Deduct stock
                $product->stock -= $cartItem->quantity;
                $product->save();


                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price * $cartItem->quantity,
                ]);
            }
            // Handle address
            if ($request->has('address')) {
                OrderAddress::create([
                    'order_id' => $order->id,
                    'gov_id' => $request->input('gov_id'),
                    'city_id' => $request->input('city_id'),
                    'address' => $request->input('address'),
                ]);
            }
            // Commit the transaction
            DB::commit();
            // Clear the user's cart after the order is successfully placed
            $this->clearCart($user->id);
            $order = Order::with(['items' , 'address.gov' ,'address.city' ,'user'])->where('user_id' , $user->id)->first();
            // Return the created order with its details
            return $this->res(true , 'Order Created Successfully!' , 200 , new OrderAuthResource( $order ));

        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollBack();
            return $this->res(false , $e->getMessage() , 500 , $e->getLine());
        }






    }


    // Function to retrieve cart items
    private function getCartItems($userId)
    {
        
        // You can replace this with the actual logic to retrieve cart items for the user
        return Card::with('items')->where('user_id', $userId)->first();
    }

    // Function to clear the cart after order is placed
    private function clearCart($userId)
    {
        // Replace this with the actual logic to delete cart items for the user
        Card::where('user_id', $userId)->delete();
    }
    




    public function deleteOrder(Request $request)
    {
        // Start transaction to ensure all related data is deleted or nothing at all
        DB::beginTransaction();

        try {
            // Retrieve the order by its ID, ensuring it belongs to the authenticated user
            $order = Order::where('id', $request->order_id)->where('user_id', $request->user()->id )->first();

            if (!$order) {
                return $this->res(false , 'Order not found or does not belong to you' , 404);

            }

            // Check if the order status is 'pending'
            if ($order->status !== 'pending') {
                return response()->json(['error' => 'Only pending orders can be deleted'], 403);
            }
            // Delete related order items
            $order->items()->delete();

            // Delete the order
            $order->delete();

            // Commit the transaction
            DB::commit();

            return $this->res(true , 'Order Deleted Successfully!' , 200);
        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollBack();
            return $this->res(true , $e->getMessage() , 500);
        }
    }




    public function store_guest(StoreOrderGuestRequest $request){

        // Start transaction to ensure everything is done or rolled back
        DB::beginTransaction(); 
        try {
                //get total price
                $total = 0;
                $total_ship = 0;
                foreach($request->products as $pro){            
                    $product = Product::where('id' , $pro['id'])->first();
                    if(isset($product)){
                        $total += $product->price;
                    }

                    if($request->has('shipment_way') && $request->shipment_way == 'delivery'){
                        $total_ship += 50;
                    }

                }
            // Create the order
            $order = Order::create([
                'user_id' => null,
                'total_price' => $total,
                'shipment_price' => $total_ship, // Default shipment price can be 0
                'payment_method' => $request->input('payment_method', 'cash'),
                'payment_status' => 'unpaid',
                'status' => 'pending',
                'phone'=>$request->phone,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name
            ]);

            // loop all products normal item
            foreach($request->products as $pro){
                $product = Product::where('id' , $pro['id'])->first();
                // Ensure there is enough stock before proceeding
                if ($product->stock < $pro['quantity']) {
                    return $this->res(false , 'Not enough stock for product: ' . $product->name , 402);
                    
                }
    
                // Deduct stock
                $product->stock -= $pro['quantity'];
                $product->save();

                if(isset($product)){
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' =>$product->name,
                        'quantity' => $pro['quantity'],
                        'price' => $product->price * $pro['quantity'],
                    ]);

                }

            }

            // Handle address
            if ($request->has('address')) {
                OrderAddress::create([
                    'order_id' => $order->id,
                    'gov_id' => $request->input('gov_id'),
                    'city_id' => $request->input('city_id'),
                    'address' => $request->input('address'),
                ]);
            }


            DB::commit();
            // Return the created order with its details
            return $this->res(true , 'Order Created Successfully!' , 200);

        } catch (\Exception $e) {
            // Rollback the transaction if something fails
            DB::rollBack();
            return $this->res(true , $e->getMessage() , 500);

        }




    } // end guest store order




    public function get_user_ordes(Request $request){
        $user = $request->user();
        $orders = Order::with(['items' , 'address.gov' ,'address.city' ,'user'])->where('user_id' , $user->id)->paginate(10); // Paginate with 10 items per page;
        // Return the created order with its details
        return $this->res(true , 'All Users Orders !' , 200 ,  ['orders' => OrderAuthResource::collection( $orders ) ,  
           'pagination' => [
            'current_page' => $orders->currentPage(),
            'last_page' => $orders->lastPage(),
            'per_page' => $orders->perPage(),
            'total' => $orders->total(),
            'next_page_url' => $orders->nextPageUrl(),
            'prev_page_url' => $orders->previousPageUrl(),
        ]
    ]);
    }










}
