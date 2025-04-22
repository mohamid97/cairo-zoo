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
            $totalProductPrice = $this->items->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
            // Calculate shipment price as 50 times the number of products
            $shipmentPrice = $this->items->sum('quantity') * 50;
    
            // Calculate total price (product price + shipment price)
            $totalPrice = $totalProductPrice + $shipmentPrice;

        return [
            'id' => $this->id,
            'user' => new UsersResource($this->user),
            'items' => UserCardItemResource::collection($this->items),
            'total_product_price' => $totalProductPrice,   // Total product price
            'shipment_price' => $shipmentPrice,            // Shipment price (number of products * 50)
            'total_price' => $totalPrice,                  // Total price (product price + shipment)
            'created_at' => $this->created_at,
            
        ];
    }
}
