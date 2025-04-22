<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            'details'=>'required|max:2000'
        ]);
     
        try{
               // strart try transcation
                DB::beginTransaction();
            
         
                Shimpment::first()->update([
                'is_free'=>$request->is_free,
                'details'=>$request->details
                ]);

                DB::commit();
                Alert::success('Success', 'Updated Successfully ! !');
                return redirect()->route('admin.shimpments.index');

         }catch(\Exception $e){
           
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.shimpments.index');
        }// end catach




    } // end update function 


    public function show_zone(){
        $zone = ShimpmentZone::withTrashed()->get();
        return view('admin.shimpments.zones' , ['langs'=>$this->langs , 'zones'=>$zone]);
    }

    // create zone
    public function add_zone(){
        return view('admin.shimpments.add_zone' , ['langs'=>$this->langs]);
    }

    public function store_zone(Request $request){
        $request->validate([
            'name.*'=>'required|string',
            'details.*'=>'required|string',
            'price'=>'required|integer'
        ]);



        try{

            $zone = new ShimpmentZone();
            $zone->price = $request->price;
            foreach ($this->langs as $lang) {
                $zone->{'name:'.$lang->code}     = $request->name[$lang->code];
                $zone->{'details:'.$lang->code}  = $request->details[$lang->code];

            }
            $zone->save();
            Alert::success('Success', 'Updated Successfully ! !');
            return redirect()->route('admin.shimpments.Show_zone');

        }catch(\Exception $e){
        
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.shimpments.Show_zone');
        }// end catach


    }

    // edit zone 

    public function edit_zone($id){
        $zone = ShimpmentZone::findOrFail($id);
        return view('admin.shimpments.edit_zone' , ['langs'=>$this->langs , 'zone'=>$zone]);


    }


    public function update_zone(Request $request , $id){
        $request->validate([
            'name.*'=>'required|string',
            'details.*'=>'required|string',
            'price'=>'required|integer'
        ]);

        try{

            $zone =  ShimpmentZone::findOrFail($id);
            $zone->price = $request->price;
            foreach ($this->langs as $lang) {
                $zone->{'name:'.$lang->code}     = $request->name[$lang->code];
                $zone->{'details:'.$lang->code}  = $request->details[$lang->code];

            }
            $zone->save();
            Alert::success('Success', 'Updated Successfully !');
            return redirect()->route('admin.shimpments.Show_zone');

        }catch(\Exception $e){
        
            // If an exception occurs, rollback the transaction
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.shimpments.Show_zone');
        }// end catach

    }


    
    public function destroy_zone($id)
    {
        $zone = ShimpmentZone::findOrFail($id);
        $zone->forceDelete();
        Alert::success('success', 'Zone Deleted Successfully !');
        return redirect()->route('admin.shimpments.Show_zone');
    }

    public function soft_delete_zone($id)
    {
      
        $zone = ShimpmentZone::findOrFail($id);
        $zone->delete();
        Alert::success('success', 'Zone Soft Deleted Successfully !');
        return redirect()->route('admin.shimpments.Show_zone');

    }

    public function restore_zone($id)
    {
        $zone = ShimpmentZone::withTrashed()->findOrFail($id);
        $zone->restore();
        Alert::success('success', 'Zone Restored Successfully !');
        return redirect()->route('admin.shimpments.Show_zone');

    }







}
