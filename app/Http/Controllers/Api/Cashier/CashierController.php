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
use App\Models\Admin\Stock;

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
            
                if( ($coupon = $this->check_coupon($request->coupon_code)) == false){
                    return $this->res(false, __('main.invalid_coupon_or_limit_code'), 400);

                }
            }

          

            if(!$this->ckeck_stocks($request->products)){
                return $this->res(false , __('main.not_enough_stock'), 404);

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
                $discount = $productModel->getBestDiscount();
                $discount_value = $discount['value'] ?? 0;
                $discount_type = $discount['type'] ?? null;
                $price_before_discount = $productModel->sales_price;
                $price_after_discount = $price_before_discount - $discount_value;
                $total_price_before_discount = ceil($product['quantity'] * $price_before_discount);
                $total_price_after_discount = ceil($product['quantity'] * $price_after_discount);
    
            
                $orderItem = $cahier_order->items()->create([
                    'product_id' => $productModel->id,
                    'quantity' => $product['quantity'],
                    'price_before_discount' => $price_before_discount,
                    'price_after_discount' => $price_after_discount,
                    'total_price_before_discount' => $total_price_before_discount,
                    'total_price_after_discount' => $total_price_after_discount,
                    'discount_type' => $discount_type,
                    'discount_percentage'=> $discount_type === 'percentage' ? $discount_value : null,
                    'discount_amount'=> $discount_type === 'amount' ? $discount_value : null,
                ]);
            
                $productModel->stock -= $product['quantity'];
                $productModel->save();
                $productModel->deductStock($product['quantity']);
                $total_before_discount += $total_price_before_discount;
                $total_after_discount += $total_price_after_discount;
            }
            
            $cahier_order->total_amount_before_discount  = $total_before_discount;
            // if coupon is applied
            if ($coupon) {   
                $cahier_order->coupon_code = $coupon->code;
                $cahier_order->coupon_discount = $coupon->type == 'percentage' ? ceil($total_after_discount * $coupon->discount_value) / 100 : ceil($coupon->discount_value);
                $total_after_discount -= $cahier_order->coupon_discount;
                $coupon->times_used += 1;
                $coupon->save();
            } else {
                $cahier_order->coupon_discount = 0;
            }
            $cahier_order->total_amount_after_discount  = $total_after_discount;
            $cahier_order->total_discount = ceil($total_before_discount - $total_after_discount);
            $cahier_order->save();
    
            DB::commit();
            return $this->res(true, __('main.order_submitted_successfully'), 200, ['cahier_order' => new OrderResource($cahier_order)]);

        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage() , $e->getLine());
            DB::rollBack();
            return $this->res(false, __('main.error_happened'), 500);
        }


        


    }





    // check stock
    private function check_coupon($coupon_code)
    {
        $coupon = Coupon::where('code', $coupon_code)
            ->where('is_active', 1)
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->first();

        if (!isset($coupon)) {
            return false;
        }

        if ($coupon->times_used >= $coupon->usage_limit) {
            return false;
        }

        return $coupon;
    }

    // validate stock
    private function ckeck_stocks(array $products)
    {
        foreach ($products as $product) {
            $productModel = Product::find($product['product_id']);
            if (!isset($productModel)) {
                return false;

            }
            if ($productModel->stock < $product['quantity']) {
                return false;

            }
        }

        return true;

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


    // get cashier orders 
    public function cashier_orders(Request $request)
    {
        $user = $request->user();
        $orders = CashierOrder::with(['user' , 'items'])->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return $this->res(true, __('main.cashier_orders'), 200, [
            'orders' => OrderResource::collection($orders),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
                'last_page' => $orders->lastPage(),
                'next_page_url' => $orders->nextPageUrl(),
                'prev_page_url' => $orders->previousPageUrl(),
            ],
        ]);


        




    } // end cashier orders






    


}
