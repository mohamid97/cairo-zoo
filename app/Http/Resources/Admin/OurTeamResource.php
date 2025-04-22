<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OurTeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'title'  =>$this->title,
            'des'    =>$this->des,
            'name'   =>$this->name,
            'facebook'=>$this->facebook,
            'linkedin'=>$this->linkedin,
            'twitter'=>$this->twitter,
            'youtube'=>$this->youtube,
            'instagram'=>$this->instagram,
            'tiktok'=>$this->tiktok,
            'image_link'=>asset('/uploads/images/teams/'),
            'photo'=>$this->image,
        ];

    }
}
