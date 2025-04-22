<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Lang;
use Illuminate\Http\Resources\Json\JsonResource;

class CmsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $langs = Lang::all();
        $slug =[];
        foreach ($langs as $lang){
            if(isset($this->translate($lang->code)->slug)){
                $slug[$lang->code] = $this->translate($lang->code)->slug;
            }
        }


        return[
            'name'=> $this->name,
            'slug'=> $slug,
            'small_des' => $this->small_des,
//            'meta_des'=>$this->meta_des,
//            'meta_title'=>$this->meta_title,
//            'alt_image' => $this->alt_image,
//            'title_image'=>$this->title_image,
            'main_image' => $this->image,
            'image_path' => asset('uploads/images/cms'),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];

    }




}
