<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OurPartenerRequest;
use App\Models\Admin\Lang;
use App\Models\Admin\Partener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PartenerController extends Controller

{

    public $langs = [];
     public function __construct()
     {
         $this->langs = Lang::all();
     }

    public function index(Request $request)
    {
        $query = Partener::withTrashed();
        if($request->has('search') && !empty($request->search) ){
            $searchTerm = $request->search;
            $query = $query->whereHas('translations', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%');
            });
        }
        $partenrs = $query->paginate(10);
        return view('admin.parteners.index' ,[
            'parteners'=>$partenrs,
            'searchTerm' => $request->search ?? ''
        ]);
    }

    public function create()
    {
        return view('admin.parteners.add' , ['langs'=>$this->langs]);

    }

    public function edit($id)
    {
        $partener = Partener::findOrFail($id);
        return view('admin.parteners.edit' , ['partener'=>$partener , 'langs'=>$this->langs]);

    }

    public function store (OurPartenerRequest $request)
    {

        try{
            DB::beginTransaction();
            $image_name = null;
            if($request->has('icon')){
                $image_name = $request->icon->getClientOriginalName();
                $request->icon->move(public_path('uploads/images/parteners'), $image_name);
            }

            $partener = Partener::create(['icon'=>$image_name]);
            foreach ($this->langs as $lang) {
                $partener->{'name:' . $lang->code} = $request->name[$lang->code];
                $partener->{'address:' . $lang->code} = $request->address[$lang->code];
            }
            $partener->save();
            DB::commit();
            Alert::success('Success', 'Added Successfully !');
            return redirect()->back();

        }catch(\Exception $e){

            dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->back();
        }

    }

    public function update(OurPartenerRequest $request , $id)
    {
        try{
            DB::beginTransaction();
            $partener = Partener::findOrFail($id);
            if($request->has('icon')){
                $image_name = $request->icon->getClientOriginalName();
                $request->icon->move(public_path('uploads/images/parteners'), $image_name);
                if (isset($partener->icon) && file_exists(public_path('uploads/images/parteners/' .$partener->icon))) {
                    unlink(public_path('uploads/images/parteners/' .$partener->icon));
                }

                $partener->icon = $image_name;
                $partener->save();
            }
            foreach ($this->langs as $lang) {
                $partener->{'name:' . $lang->code} = $request->name[$lang->code];
                $partener->{'address:' . $lang->code} = $request->address[$lang->code];
            }
            $partener->save();
            DB::commit();
            Alert::success('Success', 'Updated Successfully ! !');
            return redirect()->back();

        }catch(\Exception $e){
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.parteners.index');
        }


    }



    public function destroy($id)
    {
        $partener = Partener::findOrFail($id);
        $partener->forceDelete();
        Alert::success('success', 'parteners  Deleted Successfully !');
        return redirect()->back();
    }

    public function soft_delete($id)
    {
        $partener = Partener::findOrFail($id);
        $partener->delete();
        Alert::success('success', 'partener Soft Deleted Successfully !');
        return redirect()->back();

    }

    public function restore($id)
    {
        $partener = Partener::withTrashed()->findOrFail($id);
        $partener->restore();
        Alert::success('success', 'parteners  Restored Successfully !');
        return redirect()->back();

    }

}
