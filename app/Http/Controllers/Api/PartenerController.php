<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PartenerResource;
use App\Models\Admin\Partener;
use Illuminate\Http\Request;
use App\Trait\ResponseTrait;


class PartenerController extends Controller
{
    use ResponseTrait;

    public function get()
    {
        $Parteners = Partener::all();
        return  $this->res(true ,'All Parteners' , 200 ,PartenerResource::collection($Parteners));

    }
}
