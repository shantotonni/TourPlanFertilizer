<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\TourPlan;
use App\Models\TourPlanAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    public function __construct()
    {
        Config::set('auth.defaults', [
            'guard' => 'admin',
            'passwords' => 'admin'
        ]);
    }
    public function adminLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'UserID' => 'required|string',
            'Password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid'], 400);
        }
        try {
            if ($token = JWTAuth::attempt(['UserID' => $request->UserID,'password' => $request->Password, 'Status' => 1])) {
                return $this->respondWithToken($token);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid Use ID or Password!'
                ],500);
            }
        } catch(\Exception $exception){
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ],500);
        }

    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }
    public function me(Request $request)
    {
        $token = $request->bearerToken();
        return $token;
        $payload = JWTAuth::setToken($token)->getPayload();
        $empcode = $payload['EmpCode'];
        return $payload;

        $personal = Admin::where('UserId', $empcode)->first();
        return response()->json([
            'personal' => $personal,
            'payload' => $payload,
        ]);
    }
    public function changePass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPass' => 'required',
            'newPass' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid'], 400);
        }
        $authUser = JWTAuth::parseToken()->authenticate();

        $check = Hash::check($request->oldPass, $authUser->Password);
        if ($check) {
            $user = Admin::find($authUser->UserID);
            $user->Password = bcrypt($request->newPass);
            $user->save();
            return response()->json(['message' => "Password changed successfully"]);
        } else {
            return response()->json(['message' => "Your current password is Invalid"], 400);
        }
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }


    public function logout()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            //UserLog::create(['UserId' => $user->ID, 'TransactionTime' => Carbon::now(), 'TransactionDetails' => "Logged Out"]);
            $this->guard()->logout();
        } catch (\Exception $exception) {

        }
        return response()->json(['message' => 'Successfully logged out']);
    }

}
