<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PartenerResource extends JsonResource
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
            'name'=>$this->name,
            'image_link'=>asset('/uploads/images/parteners/'),
            'icon'=>$this->icon,
            'address'=>$this->address
        ];


    }
}
