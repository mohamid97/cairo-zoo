<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\City;
use App\Models\Admin\Govs;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          
            'id'=>$this->id,
            'gov'=>new GovsResource(Govs::find($this->gov_id)),
            'city'=> new CitiesResource(City::find($this->city_id)),
           'address'=>$this->address
        ];
    }
}
