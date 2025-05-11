<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id'=>$this->id,
            'name'=>$this->name,
            'image_name'=> $this->image,
            'image_path'=> asset('/uploads/images/'),
            'small_des' => $this->small_des,
            'slug'=>$this->slug,
            'des'=>$this->des,
        ];
    }
}
