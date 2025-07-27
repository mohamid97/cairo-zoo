<?php

namespace App\Http\Controllers\DataEntry;
use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use App\Models\Admin\Lang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use App\Helpers\LoggerHelper;

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
        return view('data_entry.brands.index' ,[
            'brands'=>$brands,
            'searchTerm' => $request->search ?? ''
        ]);


    }
    public function create(){
        return view('data_entry.brands.add' , ['langs'=>$this->langs]);
    }
    public function store(Request $request){
        $request->validate([
            'name.*'=>'required|string|max:255',
            'slug.*'=>'required|string|max:255',
            'des.*'=>'nullable|string|max:50000',
            'image'=>'nullable|image|mimes:jpeg,png,webp,jpg,gif,svg|max:2048'
        ]);

        $image_name = null;
        if($request->has('image')){
            $image_name = $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/images/brands'), $image_name);
        }
        $brand = new Brand();
        $brand->status = '1';
        $brand->image = $image_name;
        foreach ($this->langs as $lang) {
            $brand->{'name:'.$lang->code}  = $request->name[$lang->code];
            $brand->{'des:'.$lang->code}  = $request->des[$lang->code];
            $brand->{'slug:'.$lang->code}  = $request->slug[$lang->code];
        }
        $brand->save();

        LoggerHelper::logAction('create', $brand, $brand->toArray());

        Alert::success('Success', __('main.brand_added_successfully'));
        return redirect()->route('data_entry.brands.index');
    }
    public function edit($id){

        $brand = Brand::findOrFail($id);
        return view('data_entry.brands.update', ['langs'=>$this->langs , 'brand'=>$brand]);

    }
    public function update(Request $request , $id){

        $request->validate([
            'name.*'=>'required|string|max:255',
            'slug.*'=>'required|string|max:255',
            'des.*'=>'required|string|max:50000',
            'image'=>'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:2048'
        ]);

        $brand = Brand::findOrFail($id);
        $image_name = null;
        if($request->has('image')){
            $image_name = $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/images/brands'), $image_name);
            if ($brand->image && File::exists(public_path('uploads/images/brands/' . $brand->image))) {
                File::delete(public_path('uploads/images/brands/' . $brand->image));
            }

            $brand->image = $image_name;
        }
        foreach ($this->langs as $lang) {
            $brand->{'name:'.$lang->code}  = $request->name[$lang->code];
            $brand->{'des:'.$lang->code}  = $request->des[$lang->code];
            $brand->{'slug:'.$lang->code}  = $request->slug[$lang->code];
        }

        $brand->save();
        LoggerHelper::logAction('update', $brand, $brand->toArray());

        Alert::success('Success', __('main.brand_updated_successfully'));
        return redirect()->route('data_entry.brands.index');


    }
    public function delete($id){
        $brand = Brand::findOrFail($id);
        $brand->delete();
        LoggerHelper::logAction('delete', $brand, $brand->toArray());

        Alert::success('Success', __('main.brand_deleted_successfully'));
        return redirect()->route('data_entry.brands.index');
    }
}
