<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
            // Calculate total product price
            $totalProductPricebefore = $this->items->sum(function ($item) {
                return $item->product->sales_price  * $item->quantity;
            });
            $totalProductPriceafter = $this->items->sum(function ($item) {
                return  ( $item->product->sales_price - $item->product->getBestDiscount()) * $item->quantity;
            });
    

        return [
            'id' => $this->id,
            'user' => new UsersResource($this->user),
            'items' => UserCardItemResource::collection($this->items),
            'total_product_before_discount' => $totalProductPricebefore, 
            'total_product_after_discount' => $totalProductPriceafter,  
            'shipment_price' => 0,                             
            'created_at' => $this->created_at,
            
        ];
    }
}
