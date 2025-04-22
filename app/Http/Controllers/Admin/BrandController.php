<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use App\Models\Admin\Lang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BrandController extends Controller
{
    public $langs;
    public function __construct()
    {
        $this->langs = Lang::all();

    }

    public function index(Request $request){

        $query = Brand::query();
        if($request->has('search') && !empty($request->search) ){
            $searchTerm = $request->search;
            $query->whereHas('translations', function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        $brands = $query->paginate(10);
        return view('admin.brands.index' ,[
            'brands'=>$brands,
            'searchTerm' => $request->search ?? ''
        ]);


    }
    public function create(){
        return view('admin.brands.add' , ['langs'=>$this->langs]);
    }
    public function store(Request $request){
        $request->validate([
            'name.*'=>'required|string|max:255',
        ]);
        $brand = new Brand();
        $brand->status = '1';
        foreach ($this->langs as $lang) {
            $brand->{'name:'.$lang->code}  = $request->name[$lang->code];
        }
        $brand->save();
        Alert::success('Success', 'Brand Added Successfully !');
        return redirect()->route('admin.brands.index');
    }
    public function edit($id){

        $brand = Brand::findOrFail($id);
        return view('admin.brands.update', ['langs'=>$this->langs , 'brand'=>$brand]);

    }
    public function update(Request $request , $id){

        $request->validate([
            'name.*'=>'required|string|max:255',
        ]);

        $brand = Brand::findOrFail($id);
        foreach ($this->langs as $lang) {
            $brand->{'name:'.$lang->code}  = $request->name[$lang->code];
        }

        $brand->save();
        Alert::success('Success', 'Brand Updated Successfully !');
        return redirect()->route('admin.brands.index');


    }
    public function delete($id){
        $brand = Brand::findOrFail($id);
        $brand->delete();
        Alert::success('Success', 'Brand Deleted Successfully !');
        return redirect()->route('admin.brands.index');
    }
}
