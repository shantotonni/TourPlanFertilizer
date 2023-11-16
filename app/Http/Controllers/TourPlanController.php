<?php

namespace App\Http\Controllers;

use App\Http\Resources\TourPlan\TourPlanActionsCollection;
use App\Models\TourPlan;
use App\Models\TourPlanAction;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class TourPlanController extends Controller
{
    use UserTrait;
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'destination' => 'required',
            'planDate' => 'required',
            'action' => 'required'
        ]);
        if ($validated->fails()) {
            return $validated->errors();
        }
        //TOUR PLAN
        DB::beginTransaction();
        try {
            $token = $request->bearerToken();
            $user = JWTAuth::setToken($token)->getPayload();
            $userData = $this->getUserData($user['EmpCode']);
            $tour_plan = new TourPlan();
            $tour_plan->UserId = $userData->UserId;
            $tour_plan->UserName = $userData->Name;
            $tour_plan->UserDesignation = $userData->DesgName;
            $tour_plan->Destination = $request->destination;
            $tour_plan->PlanDate = $request->planDate;
            $tour_plan->IpAddress = $request->ip();
            $tour_plan->CreatedAt = Carbon::now();
            $tour_plan->UpdatedAt = Carbon::now();
            $tour_plan->save();
            //TOUR PLAN STORE ACTION WISE
            if (count($request->action) > 0) {
                $actions = [];
                foreach ($request->action as $action) {
                    $actions[] = [
                        'TourPlanId' => $tour_plan->TourPlanId,
                        'ActionTypeId' => $action['actionId'],
                        'Objective' => $action['objective'],
                        'CreatedAt' => Carbon::now(),
                        'UpdatedAt' => Carbon::now()
                    ];
                }
                TourPlanAction::insert($actions);
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'data' => 'No action found!'
                ],400);
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully Stored'
            ]);
        } catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'data' => $exception->getMessage()
            ],500);
        }
    }
    public function executePlan(Request $request){
        try {
            $filename = $this->uploadFile($request->file('image'));
            $tour_plan_action= TourPlanAction::findOrFail($request->tourActionId);
            $tour_plan_action->Outcome = $request->outcome;
            $tour_plan_action->Lat = $request->lat;
            $tour_plan_action->Lon = $request->lon;
            $tour_plan_action->Image = $filename;
            $tour_plan_action->Status = 'Completed';
            $tour_plan_action->PlanExecutionDate = Carbon::now();
            $tour_plan_action->UpdatedAt = Carbon::now();
            $tour_plan_action->save();
            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully Stored'
            ]);
        }
        catch(\Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ],500);
        }
    }
//    image as file for api multiport
    public function uploadFile($file) {
        $image = md5(uniqid(rand(), true)) . '.' .str_replace(" ", "-", $file->getClientOriginalName());
        $destinationPath = public_path('/uploads');
        $file->move($destinationPath,$image);
        return $image;
    }
    function uploadBase64File($namePrefix,$image,$destination)
    {
        try {
            list($type, $file) = explode(';', $image);
            list(, $extension) = explode('/', $type);
            list(, $file) = explode(',', $file);
            $fileNameToStore = $namePrefix . rand(1, 100000000) . '.' . $extension;
            $source = fopen($image, 'r');
            $destination = fopen($destination . $fileNameToStore, 'w');
            stream_copy_to_stream($source, $destination);
            fclose($source);
            fclose($destination);

            return $fileNameToStore;

        } catch (\Exception $ex) {
            return '';
        }
    }


    public function actionTour(Request $request){
        $plan_execute =strtotime($request->plan_execute);
        $plan_execute = date("Y-m-d", $plan_execute);
        $tour_action = TourPlanAction::whereDate('PlanExecutionDate',$plan_execute)->get();
        if (!empty($plan_execute)){
            if ($tour_action->isEmpty()){
                return response()->json([
                    'status'=>'error',
                    'message'=>'Data Not Found'
                ]);
            }
        }else{
            return response()->json([
                'status'=>'error',
                'message'=>'Data Not Found'
            ]);
        }
        return response()->json([
            'status'=>'success',
            'data'=>$tour_action
        ]);
    }
    public function tourList(Request $request){
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $empcode = $payload['EmpCode'];
        $query = TourPlan::where('UserId',$empcode)->with('tourActions');
        if (empty($request->plan_date)) {
            $tour_plan = $query->get();
        } else {
            $tour_plan = $query->whereDate('PlanDate',$request->plan_date)->get();
        }
        if (!empty($tour_plan)){
            if ($tour_plan->isEmpty()){
                return response()->json([
                    'status'=>'error',
                    'message'=>'Data Not Found'
                ]);
            }
        }else{
            return response()->json([
                'status'=>'error',
                'message'=>'Data Not Found'
            ]);
        }
        return response()->json([
            'status'=>'success',
            'base_url' => 'https://app.acibd.com/TourPlanFertilizer/uploads/',
            'data'=>$tour_plan
        ]);
}}
