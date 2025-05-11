<?php

namespace App\Http\Resources\Cashier;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'product_id' => new ProductResource($this->product),
            'quantity' => $this->quantity,
            'price_before_discount' => $this->price_before_discount,
            'price_after_discount' => $this->price_after_discount,
            'total_price_before_discount' => $this->total_price_before_discount,
            'total_price_after_discount' => $this->total_price_after_discount,
            'discount_type' => $this->discount_type,
            'discount_percentage' => $this->discount_percentage,
            'discount_amount' => $this->discount_amount,
        ];
    }
}
