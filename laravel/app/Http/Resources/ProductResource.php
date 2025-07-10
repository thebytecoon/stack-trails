<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'category' => $this->category->display_name,
            'image' => $this->image,
            'price' => $this->price,
            'url' => route('products.show', [$this->slug]),
        ];
    }
}
