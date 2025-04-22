<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaGroupResource extends JsonResource
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
            'name'=> $this->name,
            'gallery'=>$this->whenLoaded('gallerys'),
            'files'=>$this->whenLoaded('files'),
            'viedos'=>$this->whenLoaded('viedos'),
        ];
    }
}
