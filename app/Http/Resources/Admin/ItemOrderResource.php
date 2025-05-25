<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemOrderResource extends JsonResource
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
            'product_id'=>$this->product_id,
            'product_name'=>$this->product_name,
            'sales_price'=>$this->sales_price,
            'discount'=>$this->discount,
            'price'=>$this->price,
            'quantity'=>$this->quantity,
            'product_gallery'=>new OrderProductGalleryReource(Product::find($this->product_id))
        ];
    }
    
}
