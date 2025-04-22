<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Lang;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $galleryData = $this->gallery->map(function ($item) {
            return [
                'photo' => $item->photo,
                'image_link'=>asset('/uploads/images/service/')
            ];
        });

        $langs = Lang::all();
        $slug =[];
        foreach ($langs as $lang){
            if(isset($this->translate($lang->code)->slug)){
                $slug[$lang->code] = $this->translate($lang->code)->slug;
            }
        }

        return [
            'name'      =>$this->name,
            'des'       =>$this->des,
            'meta_title'=>$this->meta_title,
            'meta_des'  =>$this->meta_des,
            'slug'      =>$slug,
            'image'     => $this->image,
            'alt_image'=>$this->alt_image,
            'title_image'=>$this->title_image,
            'small_des'=>$this->small_des,
            'photos'    => $galleryData,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at

        ];
    }
}
