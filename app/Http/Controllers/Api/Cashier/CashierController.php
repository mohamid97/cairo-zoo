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
use App\Http\Resources\Admin\CashierOrderDetail;
use App\Http\Resources\Cashier\CouponResource;
use Carbon\Carbon;




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


    public function StoreOrder(Request $request)
    {

        
        $user = $request->user();

        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'coupon_code' => 'nullable|string',
        ]);
        if ($request->has('coupon_code')) {
            // check time is valid coupon has start date and end date
            $coupon = Coupon::where('code', $request->input('coupon_code'))->where('is_active' , 1)->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())->first();
            if (!$coupon) {
                return $this->res(false, __('main.invalid_coupon_code'), 400);
            }
            if ($coupon->times_used >= $coupon->usage_limit) {
                return $this->res(false, __('main.coupon_limit'), 400);
                
            }
        }
        $products = $request->input('products');
        $cahier_order = CashierOrder::create([
            'user_id' => $user->id,
            'coupon_code' => $request->input('coupon_code'),
        ]);
 
        $total_before_discount = 0;
        $total_after_discount = 0;
        foreach ($products as $product) {
            $productModel = Product::find($product['product_id']);
            $discount = $productModel->getBestDiscount();
            if (!$productModel) {
                return $this->res(false, __('main.product_not_found'), 404);
            }
            $quantity = $product['quantity'];
            if ($productModel->stock < $quantity) {
                return $this->res(false, __('main.not_enough_stock') . $productModel->name, 400);
            }
            // create order item
            $orderItem = $cahier_order->items()->create([
                'product_id' => $productModel->id,
                'quantity' => $quantity,
                'price_before_discount' => $productModel->sales_price,
                'price_after_discount' => $productModel->sales_price - $discount['value'],
                'total_price_before_discount' => ceil($quantity * $productModel->sales_price),
                'total_price_after_discount' => ceil( $quantity *  ($productModel->sales_price - $discount['value'] )),
                'discount_type' => $discount['type'],
                'discount_percentage'=> $discount['type'] === 'percentage' ? $discount['value'] : null,
                'discount_amount'=> $discount['type'] === 'amount' ? $discount['value'] : null,
                
            ]);
            // update product stock
            $productModel->stock -= $quantity;
            $productModel->save();

            
            // calculate total
            $total_before_discount += $orderItem->total_price_before_discount;
            $total_after_discount += $orderItem->total_price_after_discount;
        }
        $cahier_order->total_amount_before_discount  = $total_before_discount;
        $cahier_order->total_amount_after_discount  = $total_after_discount;
        $cahier_order->total_discount = $total_before_discount - $total_after_discount;
        $cahier_order->save();

        
        return $this->res(true, __('main.order_submitted_successfully'), 200, ['order' => new OrderResource($order)]);

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
