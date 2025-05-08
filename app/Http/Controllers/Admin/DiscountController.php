<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDiscountRequest;
use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Admin\Discounts;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DiscountController extends Controller
{
    public function index(){
        return view('admin.discounts.index', ['discounts'=>Discounts::with(['product', 'brand', 'category'])->latest()->get()]);
    }
    // add function
    public function add(){
        return view('admin.discounts.add');
    }

    public function store(StoreDiscountRequest $request){

         Discounts::create([
            'type'=>$request->type,
            'target_id'=>$request->type === 'global' ? null : $request->target_id,
            'percentage'=>$request->percentage,
            'discount_percentage' => $request->percentage == 'YES' ? $request->discount_value_percentage : null,
            'discount_amount' => $request->percentage == 'NO' ? $request->discount_value : null,

        ]);
        Alert::success('success',__('main.discount_added_successfully'));
        return redirect()->back();

    }

    public function target($type){
        $results = [];
        switch ($type) {
            case 'product':
                $results = Product::all();
                break;
            case 'category':
                $results = Category::all();
                break;
            case 'brand':
                $results = Brand::all();
                break;
        }
        return response()->json($results->map(fn($item) => [
            'id' => $item->id,
            'name' => is_array($item->name) ? ($item->name[app()->getLocale()] ?? reset($item->name)) : $item->name,
        ]));

    }


    public function delete($id){
        Discounts::findOrFail($id)->delete();
        Alert::success('success',__('main.discount_deleted_successfully'));
        return redirect()->back();
    }





}
