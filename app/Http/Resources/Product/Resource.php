<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => sprintf('/storage/images/%s', $this->image),
            'created_at' => $this->created_at,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name
            ]
        ];
    }
}
