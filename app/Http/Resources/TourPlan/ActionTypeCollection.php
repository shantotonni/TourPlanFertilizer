<?php

namespace App\Http\Resources\TourPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class ActionTypeCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($action) {
                return [
                    'ID' => $action->ActionTypeId,
                    'ActionName' => $action->ActionName
                ];
            }),
        ];

    }
}
