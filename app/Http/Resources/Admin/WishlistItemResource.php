<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistItemResource extends JsonResource
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
          
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'product_image' => $this->product->image,
            'thumbnail' => $this->product->thumbnail,
            'image_path'=>asset('/uploads/images/products/'),
            'product_description' => $this->product->des,
            'product_category' => $this->product->category ? $this->product->category->name : null,
            'product_brand' => $this->product->brand ? $this->product->brand->name : null,
            'barcode' => $this->product->barcode,
            'sales_price' => $this->product->sales_price,
            'price'=> ceil(($this->product->getBestDiscount()) ? $this->product->sales_price - $this->product->getBestDiscount()['value'] ?? 0 : $this->product->sales_price),
            'discount' => $this->product->getBestDiscount(),
            'stock' => $this->product->stock,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }

    
}