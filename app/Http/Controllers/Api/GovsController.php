<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CitiesResource;
use App\Http\Resources\Admin\GovsResource;
use App\Models\Admin\City;
use App\Models\Admin\Govs;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class GovsController extends Controller
{
    use ResponseTrait;
    // get all givs 
    public function all_govs(){
        $govs = Govs::whereHas('translations', function ($query) {
            $query->where('locale', '=', app()->getLocale());
        })->get();

        return  $this->res(true ,'All Govs ' , 200 , GovsResource::collection($govs));

    }

    public function cities(Request $request){

        $cities = City::where('gov_id' , $request->gov_id)->get();
        return  $this->res(true ,'All Cities ' , 200 , CitiesResource::collection($cities));

        
    }






}
