<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VillageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'district_id' => $this->district_id,
        ];
    }
}
