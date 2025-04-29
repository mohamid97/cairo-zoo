<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
use App\Models\Admin\Coupon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CouponController extends Controller
{

    public function index(Request $request)
    {
        $query = Coupon::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('code', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)->where(function ($q) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                });
            } elseif ($request->status === 'expired') {
                $query->whereNotNull('end_date')->where('end_date', '<', now());
            }
        }

        if ($request->filled('start_from')) {
            $query->whereDate('start_date', '>=', $request->start_from);
        }

        if ($request->filled('end_to')) {
            $query->whereDate('end_date', '<=', $request->end_to);
        }

        $coupons = $query->orderByDesc('id')->paginate(10);

        return view('admin.coupons.index', compact('coupons'))->with([
            'searchTerm' => $request->search,
            'statusFilter' => $request->status,
            'startFrom' => $request->start_from,
            'endTo' => $request->end_to,
        ]);
    }


    // add new coupons
    public function add(){
        return view('admin.coupons.add');
    }
    // store coupon
    public function store(StoreCouponRequest $request){

        Coupon::create([
            'code'            => $request->code,
            'type'            => $request->type,
            'discount_value'  => $request->discount_value,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'usage_limit'     => $request->usage_limit,
            'is_active'       => $request->has('is_active'),
        ]);

        Alert::success('success' , __('main.coupon_added_successfully'));
        return redirect()->back();


    }

    public function delete($id){
        Coupon::findOrFail($id)->delete();
        Alert::success('success' , __('main.coupon_deleted_successfully'));
        return redirect()->back();
    }

    public function edit($id){
        return view('admin.coupons.update' , ['coupon'=>Coupon::findOrFail($id)]);
    }

    public function update(UpdateCouponRequest $request , $id){
        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code'           => $request->code,
            'type'           => $request->type,
            'discount_value' => $request->discount_value,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'usage_limit'    => $request->usage_limit,
            'is_active'      => $request->has('is_active'),
        ]);


        Alert::success('success' , __('main.coupon_updated_successfully'));
        return redirect()->back();

    }





}
