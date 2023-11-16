<?php

namespace App\Http\Resources\TourPlan;

use Illuminate\Http\Resources\Json\JsonResource;

class TourPlanActionsResource extends JsonResource
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
            'ID'=> $this->TourActionId,
            'TourPlanId' => $this->TourPlanId,
            //'UserName'=>isset($this->TourPlan) ? $this->TourPlan->UserName:'',
            'ActionTypeId' =>$this->ActionTypeId,
            'Objective' =>$this->Objective,
            'Outcome' =>$this->Outcome,
            'Image' =>$this->Image,
            'Lat' =>$this->Lat,
            'Lon' =>$this->Lon,
            'Status' =>$this->Status,
        ];
    }
}
