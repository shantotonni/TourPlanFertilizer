<?php

namespace App\Http\Resources\TourPlan;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TourPlanActionsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($tour_action) {
                return [
                    'ID' => $tour_action->TourActionId,
                    'ActionTypeId' => $tour_action->ActionTypeId,
                    'TourPlanId' => $tour_action->TourPlanId,
                   // 'UserName'=>isset($tour_action->TourPlan) ? $tour_action->TourPlan->UserName:'',
                    'Objective' => $tour_action->Objective,
                    'Outcome' => $tour_action->Outcome,
                    'Image' => $tour_action->Image,
                    'Lat' => $tour_action->Lat,
                    'Lon' => $tour_action->Lon,
                    'Status' => $tour_action->Status,
                    'PlanExecutionDate' => $tour_action->PlanExecutionDate,
                ];
            })
        ];
    }
}
