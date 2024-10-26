<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailProductResource extends JsonResource
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
            'statusenabled' => $this->statusenabled,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'detail_products' => $this->whenLoaded('detailProducts')
        ];
    }
}
