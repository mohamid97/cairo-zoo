<?php

namespace App\Http\Resources\Cashier;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'code' => $this->code,
            'type' => $this->type,
            'discount_value' => $this->discount_value,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'times_used' => $this->times_used,
            'usage_limit' => $this->usage_limit,
            'is_active' => $this->is_active,
        ];
    }
}
