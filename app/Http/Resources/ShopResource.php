<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'shop_id'=>$this->shop_id,
            'attributes'=>[
                'name'=>$this->name,
                'photo'=>$this->photo,
                'location'=>$this->location,
                'rate'=>$this->rate,
                'rate_count'=>$this->rate_count,
            ]
        ];
    }
}
