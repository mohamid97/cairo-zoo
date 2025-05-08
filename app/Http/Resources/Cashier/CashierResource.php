<?php

namespace App\Http\Resources\Cashier;

use Illuminate\Http\Resources\Json\JsonResource;

class CashierResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'avatar_path'=> asset('uploads/images/users/'),
            'phone' => $this->phone,
            'created_at' => $this->created_at,
        ];
    }
}
