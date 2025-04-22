<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Lang;
use App\Models\Admin\Weight;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class WeightController extends Controller
{
    public $langs;
    public function __construct()
    {
        $this->langs = Lang::all();

    }

    public function index(Request $request){

        $query = Weight::query();
        if($request->has('search') && !empty($request->search) ){
            $searchTerm = $request->search;
            $query->whereHas('translations', function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        $weights = $query->paginate(10);
        return view('admin.weights.index' ,[
            'weights'=>$weights,
            'searchTerm' => $request->search ?? ''
        ]);


    }
    public function create(){
        return view('admin.weights.add' , ['langs'=>$this->langs]);
    }
    public function store(Request $request){
        $request->validate([
            'name.*'=>'required|string|max:255',
        ]);
        $weight = new Weight();
        $weight->status = '1';
        foreach ($this->langs as $lang) {
            $weight->{'name:'.$lang->code}  = $request->name[$lang->code];
        }
        $weight->save();
        Alert::success('Success', 'Weight Added Successfully !');
        return redirect()->route('admin.weights.index');
    }
    public function edit($id){

        $weight = Weight::findOrFail($id);
        return view('admin.weights.update', ['langs'=>$this->langs , 'weight'=>$weight]);

    }
    public function update(Request $request , $id){

        $request->validate([
            'name.*'=>'required|string|max:255',
        ]);

        $weight = Weight::findOrFail($id);
        foreach ($this->langs as $lang) {
            $weight->{'name:'.$lang->code}  = $request->name[$lang->code];
        }

        $weight->save();
        Alert::success('Success', 'Weight Updated Successfully !');
        return redirect()->route('admin.weights.index');


    }
    public function delete($id){
        $weight = Weight::findOrFail($id);
        $weight->delete();
        Alert::success('Success', 'Weight Deleted Successfully !');
        return redirect()->route('admin.weights.index');
    }
}
