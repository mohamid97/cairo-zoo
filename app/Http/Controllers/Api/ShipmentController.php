<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ShipmentCityResource;
use App\Http\Resources\Admin\ShipmentZoneResource;
use App\Models\Admin\City;
use App\Models\Admin\Shimpment;
use App\Models\Admin\ShimpmentZone;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    use ResponseTrait;
    public function setting(){
        $setting = Shimpment::first();
        return $this->res(true , __('settings') , 200 , ['settings'=>$setting]);
    }
    // get all zones
    public function zones(){
        $shipment_zones = ShimpmentZone::all();
        return $this->res(true , __('main.zones') , 200 , ShipmentZoneResource::collection($shipment_zones));
    }



    public function cities($zone_id){
        $shipment_cities = City::with('zone')->where('zone_id' , $zone_id)->get();
        if ($shipment_cities->isEmpty()) {
            return $this->res(false, __('main.no_cities_found'), 404);
        }
        return $this->res(true , __('main.cities') , 200 , ShipmentCityResource::collection($shipment_cities));
    }



}
