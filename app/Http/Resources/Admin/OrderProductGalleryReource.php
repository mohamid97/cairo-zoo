<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductGalleryReource extends JsonResource
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
                'gallery'=>ProductGallerResource::collection($this->gallery),
                // 'discount'=>$this->discount,
                // 'old_price'=>$this->old_price,
                // 'sku'=>$this->sku,
                // 'stock'=>$this->stock,
                // 'name'=>$this->name


        ];
    }
}
