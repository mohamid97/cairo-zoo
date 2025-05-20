<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CashierOrder;
use App\Models\Admin\DiffPrice;
use App\Models\Admin\Product;
use Illuminate\Http\Request;

class CahierOrderController extends Controller
{
    // index function
    public function index(Request $request)
    {

        // need to filter by product id  als if filter by has dicount
        $cahier_orders = CashierOrder::with(['items' , 'user']);

        if($request->has('product_id')){
            $cahier_orders = $cahier_orders->whereHas('items', function($query) use ($request){
                $query->where('product_id' , $request->product_id);
            });
        }

        if($request->has('has_discount')){
            $cahier_orders = $cahier_orders->where('total_amount_after_discount' , '!=' , null);
        }

         $cahier_orders = $cahier_orders->paginate(20);
        return view('admin.cahier_orders.index' ,
        [
            'cahier_orders' =>$cahier_orders,
            'products'=>Product::all(),
        ]);

    } //end of index function



        public function show($id)
    {
        $order = CashierOrder::with(['items.product', 'user'])->findOrFail($id);

        return view('admin.cahier_orders.order_details', [
            'order' => $order,
            'order_items' => $order->items,
        ]);
    }









}
