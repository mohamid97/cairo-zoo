<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsProps extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if(!isset($this->translations)){
            return null;
        }
        // Get the first translation, if it exists
        $firstTranslation = $this->translations->where('locale' , app()->getLocale())->first();

        return [
            'id' => $this->id,
            'name' => $firstTranslation ? $firstTranslation->name : null,
            'value' => $firstTranslation ? $firstTranslation->value : null,
        ];
    }


}
