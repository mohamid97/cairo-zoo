<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ResponseTrait;

class CashierController extends Controller
{
    use ResponseTrait;
    // login cashier
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        
        //return token if the user is cashierc to frontend
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            if ($user->type !== 'cashier') {
                $this->res(false, 'Access denied. You do not have cashier permissions.', 403);
            }
            $token = $user->createToken('CashierToken')->plainTextToken;
            return $this->res(true, 'Login successful', 200, ['token' => $token,'user' => $user]);
        }

        return $this->res(false, 'Invalid credentials', 401);        
    }
    // logout cashier
    public function logout(Request $request)
    {
        auth()->logout();
        $this->res(true, 'Logout successful', 200);
    }

    // get cashier info
    public function getCashierInfo(Request $request)
    {
        $user = $request->user();
        if ($user->type !== 'cashier') {
            return $this->res(false, 'Access denied.', 403);
        }

        return $this->res(true, 'Cashier info', 200, ['user' => new CashierResource($user)]);
      
    }


    public function getProduct(Request $request)
    {
        if (!$request->has('barcode')) {
            return $this->res(false, 'Barcode is required', 400);
        }
        $barcode = $request->input('barcode');
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return $this->res(false, 'Product not found', 404);
        }

        return $this->res(true, 'Product found', 200, ['product' => new ProductResource($product)]);
    }


    public function StoreOrder(Request $request)
    {
        $user = $request->user();
        $order = new Order();
        $order->cashier_id = $user->id;
        $order->total_price = $request->input('total_price');
        $order->save();

        foreach ($request->input('products') as $productData) {
            $product = Product::find($productData['id']);
            if ($product) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $product->id;
                $orderProduct->quantity = $productData['quantity'];
                $orderProduct->save();
            }
        }       
        
        return $this->res(true, 'Order submitted successfully', 200, ['order' => new OrderResource($order)]);
        
    }





}
