<?php

namespace App\Http\Resources\Cashier;

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'barcode' => $this->barcode,
            'brand' => $this->brand ? $this->brand->name : null,
            'category' => $this->category ? $this->category->name : null,
            'image' => $this->image,
            'thumbinal' => $this->thumbinal,
            'image_path' => asset('uploads/images/products/'),
            'sku' => $this->sku,
            'stock' => $this->stock,
            'before_discount' => $this->sales_price,
            'after_dicount'=> $this->getPriceAfterDiscount(),
            'discount' => $this->getBestDiscount(),
            
            
        ];
    }
    
}
