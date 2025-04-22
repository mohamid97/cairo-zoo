<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamRequest;
use App\Http\Requests\Admin\UpdateTeamRequest;
use App\Models\Admin\Lang;
use App\Models\Admin\Ourteam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class OurteamController extends Controller
{

    protected $langs;
    //

    public function __construct()
    {
        $this->langs = Lang::all();
    }
    //
    public function get()  {
        $ourteams = Ourteam::withTrashed()->get();
        return view('admin.ourteam.index' , ['teams'=>$ourteams , 'langs'=>$this->langs]);
    }




    public function create()
    {
        return view('admin.ourteam.add' , ['langs' => $this->langs]);

    }

    public function store(StoreTeamRequest $request)
    {


        try{

            $image_name ='';
            if($request->has('image')){
                $image_name = time() . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/images/teams'), $image_name);
            }


            $team = Ourteam::create([
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
                'youtube' => $request->youtube,
                'tiktok' => $request->tiktok,
                'linkedin' => $request->linkedin,
                'image' => $image_name
            ]);


            foreach ($this->langs as $lang) {
                $team->{'title:'.$lang->code}  = $request->title[$lang->code];
                $team->{'name:'.$lang->code}  = $request->name[$lang->code];
                $team->{'des:'.$lang->code}  = $request->des[$lang->code];

            }
            $team->save();
            DB::commit();
            Alert::success('Success', 'Your Member saved !');
            return redirect()->route('admin.ourteam.index');

        }catch(\Exception $e){
            dd($e->getMessage() , $e->getLine());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.ourteam.index');
        }

    }

    public function edit($id){
        try{
            return view('admin.ourteam.update' , ['team'=> Ourteam::findOrFail($id) , 'langs'=> $this->langs]);

        }catch(\Exception $e){
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.ourteam.index');
        }
    }

    public function update(UpdateTeamRequest $request , $id)
    {

        try{
            DB::beginTransaction();
            $team = Ourteam::findOrFail($id);
            if ($request->has('image')) {
                $image_name = time() . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/images/teams'), $image_name);
                if ($team->image && file_exists(public_path('uploads/images/teams/' . $team->image))) {
                    unlink(public_path('uploads/images/teams/' . $team->image));
                }
                $team->image = $image_name;
            }
            $team->facebook = $request->facebook;
            $team->twitter = $request->twitter;
            $team->instagram = $request->instagram;
            $team->youtube = $request->youtube;
            $team->tiktok = $request->tiktok;
            $team->linkedin = $request->linkedin;

            foreach ($this->langs as $lang) {
                $team->{'title:' . $lang->code} = $request->title[$lang->code];
                $team->{'name:' . $lang->code} = $request->name[$lang->code];
                $team->{'des:' . $lang->code} = $request->des[$lang->code];

            }

            $team->save();
            DB::commit();
            Alert::success('Success', 'Your Member updated successfully!');
            return redirect()->route('admin.ourteam.index');


        }catch(\Exception $e){
            DB::rollBack();
            dd($e->getMessage() , $e->getLine());

        }

    }

    public function destroy($id)
    {
        $team = Ourteam::findOrFail($id);
        $team->forceDelete();
        Alert::success('success', 'Member Deleted Successfully !');
        return redirect()->route('admin.ourteam.index');
    }

    public function soft_delete($id)
    {
        $team = Ourteam::findOrFail($id);
        $team->delete();
        Alert::success('success', 'Member Soft Deleted Successfully !');
        return redirect()->route('admin.ourteam.index');
    }

    public function restore($id)
    {
        $team = Ourteam::withTrashed()->findOrFail($id);
        $team->restore();
        Alert::success('success', 'Member Restored Successfully !');
        return redirect()->route('admin.ourteam.index');

    }







}
