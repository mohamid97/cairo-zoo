<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TasteReource extends JsonResource
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
            'name'=>$this->name,
            'des'=>$this->des,
            'slug'=>$this->slug,
            'image'=>$this->image,
            'image_path'=>asset('upload/images/taste'),
            'created_at'=>$this->created_at
        ];
    }
}
