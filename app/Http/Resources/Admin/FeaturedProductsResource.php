<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class FeaturedProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      //  dd($this->product->old_price);
        return [

            'id'  =>$this->product->id,
            'category' =>isset($this->category_id) ? new CategoryDetailsResource( Category::find($this->category)): null,
            'name'        =>$this->product->name,
            'image_path'  =>asset('uploads/images/gallery'),
            'stock'       =>$this->product->stock,
            'price'       =>$this->product->price,
            'discount'    =>$this->product->discount,
            'old_price'   =>$this->product->old_price,
            'des'         =>$this->product->des,
            'slug'        =>$this->product->slug,
            'gallery'     =>$this->product->gallery,
            'sku'=>$this->product->sku,
            'files'=> ProductFileResource::collection($this->files),
            'file_path'=>asset('uploads/images/products'),
            'video'=> $this->video

        ];
    }
}
