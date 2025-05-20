<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DiffPrice;
use App\Models\Admin\Product;
use App\Models\Front\Order;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class StatisticsController extends Controller
{
    //
    public function diff(Request $request){

        $query = DiffPrice::with('product');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $diffs = $query->paginate(20);

        return view('admin.cahier_orders.diff', compact('diffs'));


    } //


    public function store_data(Request $request)
    {
        $query = Product::with('stocks');
        if ($request->product_id) {
            $query->where('id', $request->product_id);
        }

        // Paginate the query directly
        $products = $query->paginate(10);

        return view('admin.statistics.store_data', ['products'=>$products  , 'all_products'=>Product::all() , 'selectedProduct'=>$request->product_id ?? null]);
    }




}
