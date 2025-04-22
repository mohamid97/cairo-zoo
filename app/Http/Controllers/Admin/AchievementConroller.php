<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Achievement;
use App\Models\Admin\Lang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AchievementConroller extends Controller
{
    public $langs;
    public function __construct()
    {
        $this->langs = Lang::all();

    }
    public function index(Request $request)
    {
        $query = Achievement::query();
        if($request->has('search') && !empty($request->search) ){
            $searchTerm = $request->search;
            $query->whereHas('translations', function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        $achives = $query->paginate(10);
        return view('admin.achieve.index' ,[
            'achieves'=>$achives,
            'searchTerm' => $request->search ?? ''
        ]);

    }

    public function create(){
        return view('admin.achieve.add' , ['langs'=>$this->langs]);
    }

    public function store(Request $request){
        $request->validate([
            'name.*'=>'required|string|max:255',
            'icon'=>'nullable|image',
            'des.*'=>'nullable|string',
            'number'=>'nullable|integer'
        ]);

        $image_name = null;
        if($request->has('icon')){
            $image_name = $request->icon->getClientOriginalName();
            $request->icon->move(public_path('uploads/images/achievements'), $image_name);
        }
        $ach = new Achievement();
        $ach->icon = $image_name;
        $ach->number = $request->number;
        $ach->save();
        foreach ($this->langs as $lang) {
            $ach->{'name:' . $lang->code} = $request->name[$lang->code];
            $ach->{'des:' . $lang->code} = $request->des[$lang->code];

        }

        $ach->save();
        Alert::success('Success', 'Achievement Added Successfully !');
        return redirect()->route('admin.ach.index');

    }

    public function edit($id){
        $achievement = Achievement::findOrFail($id);
        return view('admin.achieve.update' , ['langs'=>$this->langs , 'achievement'=>$achievement]);
    }
    public function update(Request $request , $id)
    {
        $achievement = Achievement::findOrFail($id);

        $request->validate([
            'name.*'=>'required|string|max:255',
            'icon'=>'nullable|image',
            'des.*'=>'nullable|string',
            'number'=>'nullable|integer'
        ]);


        $image_name = $achievement->icon;
        if($request->has('icon')){
            $image_name = $request->icon->getClientOriginalName();
            $request->icon->move(public_path('uploads/images/achievements'), $image_name);
        }
        $achievement->icon = $image_name;
        $achievement->number = $request->number;
        $achievement->save();
        foreach ($this->langs as $lang) {
            $achievement->{'name:' . $lang->code} = $request->name[$lang->code];
            $achievement->{'des:' . $lang->code} = $request->des[$lang->code];

        }

        $achievement->save();

        Alert::success('success', 'Achievement Updated Successfully !');
        return redirect()->route('admin.ach.index');

    }

    public function delete($id){
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();
        Alert::success('success', 'Achievement Delete Successfully !');
        return redirect()->route('admin.ach.index');

    }


}
