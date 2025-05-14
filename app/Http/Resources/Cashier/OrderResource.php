<?php

namespace App\Http\Resources\Cashier;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'coupon_code' => $this->coupon_code,
            'coupon_discount' => $this->coupon_discount,
            'total_amount_before_discount' => $this->total_amount_before_discount,
            'total_amount_after_discount' => $this->total_amount_after_discount,
            'total_discount' => $this->total_discount,
            'created_at' => $this->created_at->toDateTimeString(),
            'items' => OrderItemResource::collection($this->items),
        ];
    }
}
