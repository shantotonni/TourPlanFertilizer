<?php

namespace App\Http\Resources\TourPlan;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TourPlansCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'data'=>$this->collection->transform(function ($tour_plan){
                return[
                  'ID'=>$tour_plan->TourPlanId,
                  'UserName'=>$tour_plan->UserName,
                  'UserId'=>$tour_plan->UserId,
                  'UserDesignation'=>$tour_plan->UserDesignation,
                  'Destination'=>$tour_plan->Destination,
                  'PlanDate'=>$tour_plan->PlanDate,
                  'IpAddress'=>$tour_plan->IpAddress,
                ];
            })
        ];
    }
}
