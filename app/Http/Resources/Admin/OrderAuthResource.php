<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\OrderAddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

use function PHPSTORM_META\map;

class OrderAuthResource extends JsonResource
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
            'user'=> new UserDetailsResource($this->user),
            'phone'=>$this->phone,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'items'=> ItemOrderResource::collection($this->items),
            'address'=>new OrderAddressResource($this->address),
            'total_price_after_discount'=>$this->total_price_after_discount,
            'total_price_before_discount'=>$this->total_price_before_discount,
            'shipment_way'=>$this->shipment_way,
            'status'=>$this->status,
            'coupon_code'=>$this->coupon_code,
            'coupon_discount'=>$this->coupon_discount,
            'discount_type'=>$this->discount_type,
            'shipment_price'=>$this->shipment_price,
            'created_at'=>$this->created_at,
            'payment_status'=>$this->payment_status,
            'payment_method'=>$this->payment_method,
            'zone'=>$this->zone,
            'city'=>$this->city,
        ];
    }
}
