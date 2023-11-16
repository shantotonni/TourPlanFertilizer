<?php

namespace App\Http\Resources\TourPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class TourPlansResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'ID'=>$this->TourPlanId,
            'UserId'=>$this->UserId,
            'UserName'=>$this->UserName,
            'UserDesignation'=>$this->UserDesignation,
            'Destination'=>$this->Destination,
            'PlanDate'=>$this->PlanDate,
            'IpAddress'=>$this->IpAddress,
        ];
    }
}
