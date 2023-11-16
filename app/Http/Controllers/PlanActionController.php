<?php

namespace App\Http\Controllers;

use App\Models\ActionType;
use Illuminate\Http\Request;

class PlanActionController extends Controller
{
    public function list(Request $request){
        $actions = ActionType::all();
        return response()->json([
            'status'=>'success',
            'data'=>$actions
        ]);
    }
}
