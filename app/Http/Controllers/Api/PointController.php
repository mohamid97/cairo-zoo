<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class PointController extends Controller
{
    use ResponseTrait;
    //
    public function get(Request $request)
    {
        $user = $request->user();
        return $this->res(true , __('main.user_points')  , 200 , ['user'=>['points' => $user->points , 'pounds' => $user->pounds]]);
      
    }
}
