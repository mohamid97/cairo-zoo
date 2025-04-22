<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Lang;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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


        return [
            'id'=>$this->id,
            'price'    =>$this->price,
            'category' =>isset($this->category_id) ? new CategoryDetailsResource($this->category): null,
            'name'     =>$this->name,
            'des'       =>$this->des,
            'meta_title'=>$this->meta_title,
            'meta_des'  =>$this->meta_des,
            'slug'=> $slug,
            'sku'=>$this->sku,
            'stock'=>$this->stock,
            'old_price'=>$this->old_price,
            'discount'=>$this->discount,
            'gallery' => $this->gallery && $this->gallery->isNotEmpty() ? ProductGallerResource::collection($this->gallery) : null,
            'files' => $this->files && $this->files->isNotEmpty() ? ProductFileResource::collection($this->files) : null,
            'props' => $this->props ? ProductsProps::collection($this->props) : null,
            'file_path'=>asset('uploads/images/products'),
            'video'=> $this->video,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}
