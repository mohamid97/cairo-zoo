<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Front\Order;
use Illuminate\Http\Request;
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
            $query->orderBy('created_at', $request->sort);
        } else {
            $query->orderBy('created_at', 'desc');
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
             $order = Order::findOrFail($id);
             $request->validate([
                 'status' => 'required|in:pending,procced,on-way,finshed,canceled',
                 'payment_status' => 'required|in:paid,unpaid',
             ]);
             $order->status = $request->status;
             $order->payment_status = $request->payment_status;
             $order->save();
             Alert::success('Success', 'Order status updated successfully.');
             return redirect()->route('admin.orders.index');
         }catch (\Exception $e){
             Alert::success('error', 'Error Happened Tell Programmer To Solve Problem.');
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





}
