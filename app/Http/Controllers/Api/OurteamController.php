<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OurTeamResource;
use App\Models\Admin\Ourteam;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class OurteamController extends Controller
{
    use ResponseTrait;
    public function get(){
        $teams = Ourteam::all();
        return  $this->res(true ,'Our Team ' , 200 , OurTeamResource::collection($teams));
    } // end get method


}
