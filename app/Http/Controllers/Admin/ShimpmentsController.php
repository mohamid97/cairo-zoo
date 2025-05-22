<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\City;
use App\Models\Admin\Lang;
use App\Models\Admin\Shimpment;
use App\Models\Admin\ShimpmentZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ShimpmentsController extends Controller
{
    //

    public $langs;
    public function __construct()
    {
        $this->langs = Lang::all();
        
    }

    public function index(){

        $shim = Shimpment::first();
        return view('admin.shimpments.index' , ['shimp'=>$shim , 'langs'=>$this->langs]);
    }

    public function update(Request $request){

        
        $request->validate([
            'is_free'=>'required|in:paid,free',
            'min_to_free'=>'nullable|integer'
        ]);
     
        try{
                DB::beginTransaction();
                Shimpment::first()->update([
                'is_free'=>$request->is_free,
                'min_to_free'=>$request->min_to_free
                ]);

                DB::commit();
                Alert::success('Success', 'Updated Successfully ! !');
                return redirect()->route('admin.shimpments.index');

         }catch(\Exception $e){
           
            DB::rollBack();
            Alert::error('error', __('main.programer_error'));
            return redirect()->route('admin.shimpments.index');
        }




    } // end update function 


    public function show_zone(){
        $zone = ShimpmentZone::withTrashed()->get();
        return view('admin.shimpments.zones' , ['langs'=>$this->langs , 'zones'=>$zone]);
    }

    public function show_city()
    {
        $cities = City::with('zone')->get();
        return view('admin.shimpments.cities', ['langs' => $this->langs, 'cities' => $cities]);
    }

    // create zone
    public function add_zone(){
        return view('admin.shimpments.add_zone' , ['langs'=>$this->langs]);
    }

    public function add_city(){

        return view('admin.shimpments.add_city' , ['langs'=>$this->langs  , 'zones'=>ShimpmentZone::all()]);

    }

    public function store_zone(Request $request){
        $request->validate([
            'name.*'=>'required|string',
            'price'=>'required|integer'
        ]);



        try{

            $zone = new ShimpmentZone();
            $zone->price = $request->price;
            foreach ($this->langs as $lang) {
                $zone->{'name:'.$lang->code}     = $request->name[$lang->code];

            }
            $zone->save();
            Alert::success('Success', __('main.zone_add_successfully'));
            return redirect()->route('admin.shimpments.Show_zone');

        }catch(\Exception $e){
        
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', __('main.programer_error'));
            return redirect()->route('admin.shimpments.Show_zone');
        }// end catach


    }


    public function store_city(Request $request)
    {
        $request->validate([
            'name.*' => 'required|string',
            'zone_id' => 'required|exists:shimpment_zones,id'
        ]);

        try {
            $city = new City();
            $city->zone_id = $request->zone_id;
            foreach ($this->langs as $lang) {
                $city->{'name:' . $lang->code} = $request->name[$lang->code];
            }
            $city->save();
            Alert::success('Success', __('main.city_add_successfully'));
            return redirect()->route('admin.shimpments.show_city');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('error', __('main.programer_error'));
            return redirect()->route('aadmin.shimpments.show_city');
        }
    }

    // edit zone 

    public function edit_zone($id){
        $zone = ShimpmentZone::findOrFail($id);
        return view('admin.shimpments.edit_zone' , ['langs'=>$this->langs , 'zone'=>$zone]);


    }


    public function update_zone(Request $request , $id){
        $request->validate([
            'name.*'=>'required|string',
            'price'=>'required|integer'
        ]);

        try{

            $zone =  ShimpmentZone::findOrFail($id);
            $zone->price = $request->price;
            foreach ($this->langs as $lang) {
                $zone->{'name:'.$lang->code}     = $request->name[$lang->code];

            }
            $zone->save();
            Alert::success('Success', __('main.zone_updated_successfully'));
            return redirect()->route('admin.shimpments.Show_zone');

        }catch(\Exception $e){
        
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', __('main.programer_error'));
            return redirect()->route('admin.shimpments.Show_zone');
        }// end catach

    }


    
    public function destroy_zone($id)
    {
        $zone = ShimpmentZone::findOrFail($id);
        $zone->forceDelete();
        Alert::success('success', __('main.zone_deleted'));
        return redirect()->route('admin.shimpments.Show_zone');
    }

    public function destroy_city($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        Alert::success('success', __('main.city_deleted'));
        return redirect()->route('admin.shimpments.show_city');
    }

    // public function soft_delete_zone($id)
    // {
      
    //     $zone = ShimpmentZone::findOrFail($id);
    //     $zone->delete();
    //     Alert::success('success', 'Zone Soft Deleted Successfully !');
    //     return redirect()->route('admin.shimpments.Show_zone');

    // }

    // public function restore_zone($id)
    // {
    //     $zone = ShimpmentZone::withTrashed()->findOrFail($id);
    //     $zone->restore();
    //     Alert::success('success', 'Zone Restored Successfully !');
    //     return redirect()->route('admin.shimpments.Show_zone');

    // }







}
