<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
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
            'works_id'=>$this->works_id,
            'user_id'=>$this->user_id,
            'attributes'=>[
                'name'=>$this->name,
                'photo'=>$this->photo,
                'jobname'=>$this->jobname,
                'address'=>$this->address,
                'email'=>$this->user->email,
                'phone'=>$this->user->phone,
                'worktime'=>$this->worktime,
                'rate_count'=>$this->rate_count,
                'rate'=>$this->rate
            ]
        ];
    }
}
