<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Lang;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
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
            'sales_price'    =>$this->sales_price,
            'price'=> ceil(($this->getBestDiscount()) ? $this->sales_price - $this->getBestDiscount()['value'] ?? 0 : $this->sales_price),
            'category' =>isset($this->category_id) ? new CategoryDetailsResource($this->category): null,
            'taste'=>isset($this->taste_id) ? new TasteReource($this->taste): null,
            'name'     =>$this->name,
            'des'       =>$this->des,
            'meta_title'=>$this->meta_title,
            'meta_des'  =>$this->meta_des,
            'slug'      =>$slug,
            'sku'=> $this->sku,
            'thumbinal'=> $this->thumbinal,
            'image'=> $this->image,
            'barcode'=> $this->barcode,
            'brand' => isset($this->brand_id) ? new BrandResource($this->brand) : null,
            // 'old_price'=>$this->old_price,
            'discount'=>$this->getBestDiscount(),
            'gallery' => $this->gallery && $this->gallery->isNotEmpty() ? ProductGallerResource::collection($this->gallery) : null,
            'files' => $this->files && $this->files->isNotEmpty() ? ProductFileResource::collection($this->files) : null,
            'props' => $this->props ? ProductsProps::collection($this->props) : null,
            'stock'=>$this->stock,
            'file_path'=>asset('uploads/images/products'),
            'video'=> $this->video,
            'related_products' => $this->relatedProducts && $this->relatedProducts->isNotEmpty() ? ProductResource::collection($this->relatedProducts) : null,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at

        ];
    }
}