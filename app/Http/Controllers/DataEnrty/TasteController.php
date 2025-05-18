<?php

namespace App\Http\Controllers\DataEnrty;

use App\Helpers\LoggerHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTasteRequest;
use App\Models\Admin\Lang;
use App\Models\Admin\Taste;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TasteController extends Controller
{
    public $langs;

    public function __construct()
    {
        $this->langs = Lang::all();

    }

    public function index()
    {
        $search = request()->query('search');
        $tastes = Taste::whereHas('translations', function($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->orderBy('created_at' , 'desc')
            ->paginate(20);

        return view('data_entry.taste.index' , ['tastes' => $tastes , 'searchTerm' => $search ]);
    } // end index page



    public function create()
    {
        return view('data_entry.taste.add' , ['langs' => $this->langs]);
    } // end create page


    // store taste
    public function store(StoreTasteRequest $request)
    {


        $image_name = null;
        if($request->has('image')){
            $image_name = $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/images/taste'), $image_name);
        }

        $taste = Taste::create([
            'image' => $image_name,
        ]);

        foreach ($this->langs as $lang) {
            $taste->{'name:'.$lang->code}  = $request->name[$lang->code];
            $taste->{'slug:'.$lang->code}  = $request->slug[$lang->code];
            $taste->{'des:'.$lang->code}  = $request->des[$lang->code];
        }
        $taste->save();

        LoggerHelper::logAction('create', $taste, $taste->toArray());

        Alert::success('Success', __('main.taste_added_successfully'));
        return redirect()->route('data_entry.tastes.index');

    } // end store taste



    public function edit($id)
    {
        $taste = Taste::findOrFail($id);
        return view('data_entry.taste.edit' , ['taste' => $taste , 'langs' => $this->langs]);
    } // end edit taste




    public function update(StoreTasteRequest $request , $id)
    {
        $taste = Taste::findOrFail($id);

        if($request->has('image')){
            $image_name = $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/images/taste'), $image_name);
            if (isset($taste->image) && file_exists(public_path('uploads/images/taste/' .$taste->image))) {
                unlink(public_path('uploads/images/taste/' .$taste->image));
            }
            $taste->image = $image_name;
        }

        foreach ($this->langs as $lang) {
            $taste->{'name:'.$lang->code}  = $request->name[$lang->code];
            $taste->{'slug:'.$lang->code}  = $request->slug[$lang->code];
            $taste->{'des:'.$lang->code}  = $request->des[$lang->code];
        }
        $taste->save();
        LoggerHelper::logAction('update', $taste, $taste->toArray());
        Alert::success('Success', __('main.taste_updated_successfully'));
        return redirect()->route('data_entry.tastes.index');

    } // end update taste




    public function delete($id)
    {
        $taste = Taste::findOrFail($id);
        if (isset($taste->photo) && file_exists(public_path('uploads/images/taste/' .$taste->photo))) {
            unlink(public_path('uploads/images/taste/' .$taste->photo));
        }
        $taste->delete();


        LoggerHelper::logAction('delete', $taste, $taste->toArray());
        Alert::success('Success', __('main.taste_deleted_successfully'));
        return redirect()->route('data_entry.tastes.index');
    } // end delete taste
}
