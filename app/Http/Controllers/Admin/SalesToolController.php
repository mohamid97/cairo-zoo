<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Points;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesToolController extends Controller
{


    public function productsComparison(Request $request)
    {
        // Get the list of selected products from the request
        $selectedProducts = $request->input('products');

        // If 'all' is selected, we want to fetch sales data for all products
        if (in_array('all', $selectedProducts)) {
            $selectedProducts = Product::all()->pluck('id');
        }

        // Fetch sales data for selected products
        $salesData = Product::whereIn('products.id', $selectedProducts) // Explicitly use 'products.id'
        ->join('order_items as oi2', 'oi2.product_id', '=', 'products.id') // Explicitly join the products table
        ->join('orders', 'orders.id', '=', 'oi2.order_id')  // Join orders to get order data
        ->selectRaw('SUM(oi2.quantity * oi2.price) as total_sales, products.id as product_id')
            ->groupBy('products.id')
            ->get()
            ->map(function ($product) {
                return [
                    'product_name' => $product->name,
                    'total_sales' => $product->total_sales
                ];
            });

        return response()->json($salesData);
    }




    //
    public function index(){
        $monthlyOrders = DB::table('orders')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as total_sales'))
            ->groupBy('month')
            ->get();
        $quarterlyOrders = DB::table('orders')
            ->select(DB::raw('QUARTER(created_at) as quarter'), DB::raw('SUM(total_price) as total_sales'))
            ->groupBy('quarter')
            ->get();
        $products = Product::all();

        return view('admin.sales_tool.index' , [
            'monthlyOrders'=>$monthlyOrders,
            'quarterlyOrders'=>$quarterlyOrders,
            'products'=>$products
        ]);
    }



    public function getOrderComparison(Request $request)
    {
        $months = $request->input('months');
        $products = $request->input('products');

        // Fetch orders based on selected months and products
        $query = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(DB::raw('MONTH(orders.created_at) as month'), DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.price * order_items.quantity) as total_sales'));

        if (!in_array('all', $months)) {
            $query->whereIn(DB::raw('MONTH(orders.created_at)'), $months);
        }
        if (!in_array('all', $products)) {
            $query->whereIn('order_items.product_id', $products);
        }

        $data = $query->groupBy('month')->get();

        return response()->json($data);
    }


    public function points(){
        $pointsData = Points::select('user_id', DB::raw('SUM(points) as total_points'), DB::raw('SUM(pounds) as total_pounds'))
            ->with('user:id,first_name') // Assuming `name` is a field in the users table
            ->groupBy('user_id')
            ->get();

        return view('admin.sales_tool.points', ['pointsData' => $pointsData]);




    }




}
