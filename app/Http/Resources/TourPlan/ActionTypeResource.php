<?php

namespace App\Http\Resources\TourPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class ActionTypeResource extends JsonResource
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
            'ID' => $this->ActionTypeId,
            'ActionName' => $this->ActionName
        ];
    }
}
