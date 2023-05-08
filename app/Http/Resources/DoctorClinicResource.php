<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorClinicResource extends JsonResource
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
            'attributes'=>[
                'name'=>$this->name,
                'field'=>$this->field,
                'price'=>$this->price,
                'photo'=>$this->photo,
                'email'=>$this->user->email,
                'phone'=>$this->user->phone,
                'rate_count'=>$this->rate_count,
                'rate'=>$this->rate
            ]
        ];

    }
}
