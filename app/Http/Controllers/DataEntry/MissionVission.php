<?php

namespace App\Http\Controllers\DataEntry;

use App\Helpers\LoggerHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin\Lang;
use App\Models\Admin\MissionVission as AdminMissionVission;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MissionVission extends Controller
{
    private $langs;
    //
    public function __construct()
    {
        $this->langs = Lang::all();

    }

    public function mision_vission(){
        $mission = AdminMissionVission::first();
        return view('data_entry.mission_vission.index' , ['mission'=> $mission , 'langs'=>$this->langs]);
    }

    public function mision_vission_store(Request $request)  {

        $mission = AdminMissionVission::firstOrCreate();
        foreach ($this->langs as $lang) {
            $mission->{'services:'.$lang->code}  = $request->services[$lang->code];
            $mission->{'mission:'.$lang->code}   = $request->mission[$lang->code];
            $mission->{'vission:'.$lang->code}   = $request->vission[$lang->code];
            $mission->{'breif:'.$lang->code}     = $request->breif[$lang->code];
            $mission->{'about:'.$lang->code}     = $request->about[$lang->code];
        }
        $mission->save();
        LoggerHelper::logAction('update', $mission, $mission->toArray());

        Alert::success('Success', 'Mission And Vission Updated Successfully !');
        return redirect()->route('data_entry.mission_vission.index');


    }



}
