<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Category;
use App\Models\Admin\Lang;
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
        $langs = Lang::all();
        $slug =[];
        foreach ($langs as $lang){
            if(isset($this->product->translate($lang->code)->slug)){
                $slug[$lang->code] = $this->product->translate($lang->code)->slug;
            }
        }
        
        return [

            'id'  =>$this->product->id,
            'category' =>isset($this->product->category_id) ? new CategoryDetailsResource( Category::find($this->product->category_id)): null,
            'name'        =>$this->product->name,
            'image_path'  =>asset('uploads/images/gallery'),
            'stock'       =>$this->product->stock,
            'sales_price'       =>$this->product->sales_price,
            'price'=> ceil(($this->product->getBestDiscount()) ? $this->product->sales_price - $this->product->getBestDiscount()['value'] ?? 0 : $this->product->sales_price),
            'discount'    => $this->product->getBestDiscount(),
            'stock'   =>$this->product->stock,
            'des'         =>$this->product->des,
            'slug'        =>$slug,
            'gallery'     =>$this->product->gallery,
            'sku'=>$this->product->sku,
            'barcode'=> $this->product->barcode,
            'brand' => isset($this->product->brand_id) ? new BrandResource($this->product->brand) : null,
            'files'=> ProductFileResource::collection($this->product->files),
            'file_path'=>asset('uploads/images/products'),
            'video'=> $this->product->video,
            'related_products' => $this->product->relatedProducts && $this->product->relatedProducts->isNotEmpty() ? ProductResource::collection($this->product->relatedProducts) : null,
            'created_at'=>$this->product->created_at


        ];
    }
}