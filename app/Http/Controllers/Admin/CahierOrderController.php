<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CashierOrder;
use App\Models\Admin\DiffPrice;
use App\Models\Admin\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CahierOrderController extends Controller
{
    // index function
    public function index(Request $request)
    {

        // need to filter by product id  als if filter by has dicount
        $cahier_orders = CashierOrder::with(['items' , 'user']);

        if($request->has('product_id') && $request->product_id != ''){
            $cahier_orders = $cahier_orders->whereHas('items', function($query) use ($request){
                $query->where('product_id' , $request->product_id);
            });

        }

        if($request->has_discount && $request->has_discount !=''){
            if($request->has_discount == 'yes'){
                $cahier_orders = $cahier_orders->where('total_amount_after_discount' , '==' , null);

            }else{
                $cahier_orders = $cahier_orders->where('total_amount_after_discount' , '!=' , null);

            }
            
        }




    if($request->has('cashier_name') && $request->cashier_name != ''){
        $cahier_orders = $cahier_orders->whereHas('user', function($query) use ($request){
            $query->where('first_name', 'like', '%'.$request->cashier_name.'%')
                  ->orWhere('last_name', 'like', '%'.$request->cashier_name.'%');
        });
    }


    if ($request->has('date_from') && $request->date_from != '') {
        $from = Carbon::parse($request->date_from)->startOfDay();
        $cahier_orders = $cahier_orders->where('created_at', '>=', $from);


    }

    
    if($request->has('date_to') && $request->date_to != ''){
        $to = Carbon::parse($request->date_to)->startOfDay();
        $cahier_orders = $cahier_orders->where('created_at', '<=', $to);
    }



         $cahier_orders = $cahier_orders->paginate(20);
        return view('admin.cahier_orders.index' ,
        [
            'cahier_orders' =>$cahier_orders,
            'products'=>Product::all(),
            'selectedProduct'=>$request->product_id?? null,
            'has_discount'=>$request->has_discount??null,
            'cashier_name' => $request->cashier_name ?? null,
            'date_from' => $request->date_from ?? null,
            'date_to' => $request->date_to ?? null,
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
