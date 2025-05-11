<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ResponseTrait;
use App\Http\Resources\Cashier\CashierResource;
use App\Http\Resources\Cashier\ProductResource;
use App\Models\Admin\Product;
use App\Models\Admin\Coupon;
use App\Models\Admin\CashierOrder;
use App\Http\Resources\Cashier\CouponResource;
use App\Http\Resources\Cashier\OrderResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Cashier\StoreOrderRequest;



class CashierController extends Controller
{
    use ResponseTrait;
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (auth()->attempt($credentials)) {

            $user = auth()->user();
            if ($user->type !== 'cashier') {
                $this->res(false, __('main.access_denied'), 403);
            }
            $token = $user->createToken('CashierToken')->plainTextToken;
            return $this->res(true, __('main.login_success') ,200, ['token' => $token,'user' => $user]);
        }

        return $this->res(false, __('main.invalid_credentials'), 401);        
    }

    // logout cashier
    public function logout(Request $request)
    {
        auth()->logout();
        $this->res(true, __('main.logout_success'), 200);
    }

    // get cashier info
    public function getCashierInfo(Request $request)
    {
        $user = $request->user();
        if ($user->type !== 'cashier') {
            return $this->res(false, __('main.access_denied'), 403);
        }

        return $this->res(true, __('main.cashier_info'), 200, [new CashierResource($user)]);
      
    }


    public function getProduct(Request $request)
    {
        if (!$request->has('barcode')) {
            return $this->res(false, __('main.barcode_requried'), 400);
        }
        $barcode = $request->input('barcode');
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return $this->res(false, __('main.product_not_found'), 404);
        }


        return $this->res(true, __('main.product_found') ,  200, ['product' => new ProductResource($product)]);
    }


    public function StoreOrder(StoreOrderRequest $request)
    {
        
        try{
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

            DB::beginTransaction();
            $products = $request->input('products');
            $cahier_order = CashierOrder::create([
                'user_id' => $user->id,
                'coupon_code' => $request->input('coupon_code'),
            ]);
     
            $total_before_discount = 0;
            $total_after_discount = 0;
            foreach ($products as $product) {
                $productModel = Product::find($product['product_id']);
                
                if (!$productModel) {
                    return $this->res(false, __('main.product_not_found'), 404);
                }
            
                $discount = $productModel->getBestDiscount();
                $discount_value = $discount['value'] ?? 0;
                $discount_type = $discount['type'] ?? null;
            
                $quantity = $product['quantity'];
                if ($productModel->stock < $quantity) {
                    return $this->res(false, __('main.not_enough_stock') . $productModel->name, 400);
                }
            
                $price_before_discount = $productModel->sales_price;
                $price_after_discount = $price_before_discount - $discount_value;
    
                
                $total_price_before_discount = ceil($quantity * $price_before_discount);
                $total_price_after_discount = ceil($quantity * $price_after_discount);
                // dd($total_price_before_discount  , $total_price_after_discount);
    
            
                $orderItem = $cahier_order->items()->create([
                    'product_id' => $productModel->id,
                    'quantity' => $quantity,
                    'price_before_discount' => $price_before_discount,
                    'price_after_discount' => $price_after_discount,
                    'total_price_before_discount' => $total_price_before_discount,
                    'total_price_after_discount' => $total_price_after_discount,
                    'discount_type' => $discount_type,
                    'discount_percentage'=> $discount_type === 'percentage' ? $discount_value : null,
                    'discount_amount'=> $discount_type === 'amount' ? $discount_value : null,
                ]);
            
                $productModel->stock -= $quantity;
                $productModel->save();
            
                $total_before_discount += $total_price_before_discount;
                $total_after_discount += $total_price_after_discount;
            }
            
            $cahier_order->total_amount_before_discount  = $total_before_discount;
            $cahier_order->total_amount_after_discount  = $total_after_discount;
            $cahier_order->total_discount = $total_before_discount - $total_after_discount;
            $cahier_order->save();
    
            DB::commit();
            return $this->res(true, __('main.order_submitted_successfully'), 200, ['cahier_order' => new OrderResource($cahier_order)]);

        }catch(\Exception $e){
            DB::rollBack();
            return $this->res(false, __('main.something_went_wrong'), 500);
        }


    }

    //validate validate_coupon
    public function validate_coupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);
 
        $coupon = Coupon::where('code', $request->input('coupon_code'))->where('is_active' , 1)->whereDate('start_date', '<=', Carbon::now())
        ->whereDate('end_date', '>=', Carbon::now())->first();        
        if (!$coupon) {
            return $this->res(false, __('main.invalid_coupon_code'), 400);
        }
        if ($coupon->times_used >= $coupon->usage_limit) {
            return $this->res(false, __('main.coupon_limit'), 400);
        }
        return $this->res(true, __('main.coupon_code_is_valid'), 200 ,new CouponResource($coupon));
    }




    


}
