<?php

namespace App\Http\Controllers;

use App\Models\TourPlan;
use App\Models\TourPlanAction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{

    public function index()
    {
        return view('welcome');
    }

    public function monthlyPlan()
    {
        $tour_plans = DB::connection('tour')->select("EXEC SPCustomerActionPlan");
        return response()->json(['tour_plans' => $tour_plans]);
    }

    public function show(Request $request, $ID)
    {
        $query = TourPlan::join(
            'TourPlanActions',
            'TourPlanActions.TourPlanId',
            'TourPlans.TourPlanId')
            ->join('ActionType', function ($q) {
                $q->on('ActionType.ActionTypeId',
                    'TourPlanActions.ActionTypeId');
            });
        if ($request->export === 'Y') {
            $query->select(
                'TourPlans.UserId',
                'TourPlans.UserName',
                'TourPlans.UserDesignation',
                'TourPlans.Destination',
                'TourPlans.PlanDate',
                'ActionType.ActionName',
                'TourPlanActions.Objective',
                'TourPlanActions.Outcome',
                'TourPlanActions.Lat',
                'TourPlanActions.Lon',
                'TourPlanActions.Status',
                'TourPlanActions.PlanExecutionDate'
            );
        } else {
            $query->select(
                'TourPlans.UserId',
                'TourPlans.UserName',
                'TourPlans.UserDesignation',
                'TourPlans.Destination',
                'TourPlans.PlanDate',
                'ActionType.ActionName',
                'TourPlanActions.Objective',
                'TourPlanActions.Outcome',
                'TourPlanActions.Image',
                'TourPlanActions.Lat',
                'TourPlanActions.Lon',
                'TourPlanActions.Status',
                'TourPlanActions.PlanExecutionDate'
            );
        }

        $query->where('TourPlans.UserId', $ID);
        if (!empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('TourPlans.Destination', 'like', $request->search . '%');
            });
        }
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $from_date = Carbon::parse($request->from_date)->format('Y-m-d');
            $to_date = Carbon::parse($request->to_date)->format('Y-m-d');
            $query->whereBetween('PlanDate', [$from_date, $to_date]);
        }
        $tour_plans = $query->get();
        return response()->json([
            'tour_plans' => $tour_plans
        ]);
    }

    public function getDashboardAllData()
    {
        $data = [];
        $data['total_on_tour'] = TourPlan::count();
        $data['total_tour_activity'] = TourPlanAction::where('Status', '!=', 'complete')->count();
        $data['total_activity_complete'] = TourPlanAction::where('Status', '=', 'completed')->count();
        $data['total_channel_visit'] = TourPlanAction::where('ActionTypeId', '=', '1')->count();
        $data['total_farmer_visit'] = TourPlanAction::where('ActionTypeId', '=', '2')->count();
        $data['total_strategic_visit'] = TourPlanAction::where('ActionTypeId', '=', '3')->count();

        return response()->json([
            'data' => $data
        ]);
    }

    public function mdpExport()
    {
        $tour_plans = DB::connection('tour')->select("EXEC SPCustomerActionPlan");
        Excel::create('projects', function ($excel) use ($tour_plans) {
            $excel->sheet('Sheet 1', function ($sheet) use ($tour_plans) {
                $sheet->fromArray($tour_plans);
            });
        })->export('xls');
    }


}
