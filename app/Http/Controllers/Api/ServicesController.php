<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ServiceDetailsResource;
use App\Http\Resources\Admin\ServicesResource;
use App\Models\Admin\Service;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    use ResponseTrait;
    public function get()
    {
        $services = Service::with('gallery')->get();
        return  $this->res(true ,'All Services' , 200 ,ServicesResource::collection($services));

    }

    public function get_service_details(Request $request){

        $service_details = Service::whereHas('translations', function ($query) use($request) {
            $query->where('locale', '=', app()->getLocale())->where('slug' , $request->slug);
        })->first();

        if(optional($service_details)->exists()){
            return  $this->res(true ,'Service Details' , 200 , new ServiceDetailsResource($service_details));
        }

        return  $this->res(false ,'Service details not found. Maybe there is no data with this slug or no data in this language.' , 404);
        
    }
}
