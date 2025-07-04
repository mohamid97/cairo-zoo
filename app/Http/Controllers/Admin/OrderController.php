<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\OrderInfo;
use App\Models\Admin\Points;
use App\Models\Admin\PointsPrice;
use App\Models\Admin\Product;
use App\Models\Admin\Stock;
use App\Models\Front\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items', 'address', 'user']);

        // Search by product
        if ($request->has('product') && $request->product != null) {
            $query->whereHas('items.product', function ($q) use ($request) {
                $q->whereHas('translations', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->product . '%');
                });
            });
        }

        // Filter by user
        if ($request->has('user') && $request->user != null) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->user . '%')->orWhere('last_name', 'like', '%' . $request->user . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != null) {

            $query->where('status', $request->status);
        }



        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }




        // Sort by ascending or descending order
        if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('id', $request->sort);
        } else {
            $query->orderBy('id', 'desc');
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }




     // Show order details
     public function show_details($id)
     {
         $order = Order::with('items.product', 'address', 'user')->findOrFail($id);
         return view('admin.orders.show_details', compact('order'));
     }

     // Edit order status and payment status
     public function edit_status($id)
     {
         $order = Order::findOrFail($id);
         return view('admin.orders.edit_status', compact('order'));
     }

     // Update status and payment status
     public function update_status(Request $request, $id)
     {

         try{

             $request->validate([
                 'status' => 'required|in:pending,procced,on-way,finshed,canceled',
                 'payment_status' => 'required|in:paid,unpaid',
             ]);

            $order = Order::with(['items'])->findOrFail($id);
             if($order->status == 'canceled'){
                Alert::error('error' , __('main.order_already_cancled'));
                return redirect()->back();
             }

            if($order->status == 'finshed'){
                Alert::error('error' , __('main.order_already_finshed'));
                return redirect()->back();
             }

             
             $order->status = $request->status;
             if($request->status == 'finshed'){
                $this->add_points($order->total_after_price , $order->user , $order);
             }

             if($request->status == 'canceled'){
                $this->return_items($id , $order->items);
             }
             $order->payment_status = $request->payment_status;
             $order->save();
             Alert::success('Success', __('main.order_status_updated'));
             return redirect()->route('admin.orders.index');
         }catch (\Exception $e){
             Alert::success('error', __('main.programer_error'));
             return redirect()->route('admin.orders.index');
         }


         

     }

     // Delete order if status is pending
     public function delete($id)
     {
         $order = Order::findOrFail($id);

         if ($order->status !== 'pending') {
            Alert::error('error', 'Cannot delete order unless status is pending.');

             return redirect()->route('admin.orders.index');
         }

         $order->delete();
         Alert::success('Success', 'Order deleted successfully.');
         return redirect()->route('admin.orders.index');
     }

     public function retrieval($id){

        try{
            DB::beginTransaction();
            $order = Order::with(['user' , 'items' , 'address'])->findOrFail($id);
            if ($order->status == 'canceled') {
               Alert::error('error' , __('main.order_already_cancled'));
               return redirect()->route('admin.orders.index');

            }

            if ($order->status != 'finish') {
               Alert::error('error' , __('main.order_not_finished_to_retrieval'));
               return redirect()->route('admin.orders.index');

            }


            if(!$this->return_items($id , $order->items)){
                return redirect()->route('admin.orders.index');
            }

            $order->update(['status' => 'retrieval']);
            $this->remove_points($order , $order->user);
            Alert::success('success' , __('main.main.order_retrieved_successfully'));
            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage() , $e->getLine());
            Alert::error('error' , __('main.programer_error'));

        }



     }


     private function return_items($order_id , $items){
            foreach ($items as $item) {
                $product = Product::find($item->product_id);
                if (!$product) {
                    Alert('error' , __('main.product_not_found'));
                    return false;
                    

                }

                $product->stock += $item->quantity;
                $product->save();
                $infos = OrderInfo::where('order_id' , $order_id)->get(); 
                foreach($infos as $info){
                    $stock = Stock::where('product_id' , $info->product_id)->where('cost_price' , $info->cost_price)->where('sales_price' , $info->sales_price)->first();
                    if($stock){
                        $stock->quantity += $info->qty;
                        $stock->save();
                    }else{
                        Stock::create([
                            'product_id'=>$info->product_id,
                            'quantity'=>$info->qty,
                            'cost_price'=>$info->cost_price,
                            'sales_price'=>$info->sales_price
                        ]);
                    }
                    


                } // end foreach


            


            } // end foreach for items


            return true;
     }




    private function add_points($totalAfterPrice , $user , $order){
            $pointsPrice = PointsPrice::first();
            if(isset($pointsPrice)){
                if($pointsPrice->order_amount <= $totalAfterPrice){
                  $points = floor($totalAfterPrice / $pointsPrice->order_amount) * $pointsPrice->order_points;
                  if($points > 0){
                    $pounds = floor($points / $pointsPrice->num_points) * $pointsPrice->num_pounds;
                    Points::create([
                        'user_id' => $user->id,
                        'points' => $points,
                        'pounds' => $pounds,
                        'order_id' => $order->id,
                        
                    ]);

                    $user->points += $points;
                    $user->pounds += $pounds;
                    $user->save();
                  }

                }
            } // end points price

    }


    // remove points from user if order return 
    private function remove_points($order , $user){
        $points = Points::where('order_id' , $order->id)->first();
        if(isset($points)){
            $user->points -= $points->points;
            $user->pounds -= $points->pounds;
            $user->save();
            $points->delete();
        }

    }


    





}
