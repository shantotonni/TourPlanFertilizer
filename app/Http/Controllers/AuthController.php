<?php

namespace App\Http\Controllers;

use App\Models\ActionPlan;
use App\Models\Employee;
use App\Models\jwt\JWT;
use App\Models\Personal;
use App\Models\User;
use App\Models\UserLog;
use App\Services\AccessLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'EmpCode' => 'required|string',
            'Password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid'], 400);
        }


        $user = User::where('EmpCode', $request->EmpCode)->where('Password', $request->Password)->first();
        if ($user) {
            $user = [
                'EmpCode' => $user->EmpCode,
                'staffCode' => $user->EmpCode,
                'Business' => '',
                'type' => 'employee',
            ];
            return response()->json([
                'status' => 'success',
                'access_token' => $this->generateToken($user)
            ], 200);
        }else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wrong Staff Id or Password  '
                ], 404);
            }
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
            $user = User::find($authUser->UserID);
            $user->Password = bcrypt($request->newPass);
            $user->save();
            return response()->json(['message' => "Password changed successfully"]);
        } else {
            return response()->json(['message' => "Your current password is Invalid"], 400);
        }
    }

    public function changeProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'image' => 'required',
            'isImageChange' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid'], 400);
        }
        $authUser = JWTAuth::parseToken()->authenticate();
        $user = User::find($authUser->UserID);
        $user->UserName = $request->name;
        $user->Email = $request->email;
        $user->Phone = $request->mobile;
        if ($request->isImageChange) {
            if ($authUser->Avatar !== 'default.png') {
                try {
                    unlink(public_path('uploads/') . $authUser->Avatar);
                } catch (\Exception $e) {
                }
            }
            $image = $request->image;
            $name = rand(0, 10000000) . time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($image)->save(public_path('uploads/') . $name);
            $user->Avatar = $name;
        }
        $user->save();
        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function profileInfo(Request $request)
    {
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        $empcode = $payload['EmpCode'];

        $personal = Employee::where('EmpCode', $empcode)->with('email')->first();

        $departments = [];
        $divisions = [];
        if (!$personal) {
            $departments = ActionPlan::select('Department')->groupBy('Department')->get();
            $divisions = ActionPlan::select('Division')->groupBy('Division')->get();
        }
        return response()->json([
            'personal' => $personal,
            'payload' => $payload,
            'departments' => $departments,
            'divisions' => $divisions
        ]);
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

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard('api');
    }

    public function generateToken($user)
    {
        $payload = [
            'iat' => time(),
            'iss' => $_SERVER['SERVER_NAME'],
            'exp' => time() + 12 * 30 * (24 * 60 * 60),// 1 Month
            'EmpCode' => $user['EmpCode'],
            'staffCode' => $user['staffCode'],
            'Business' => $user['Business'],
            'Type' => $user['type'],
        ];
        try {
            $privateKey = env("JWT_SECRET", "7p2hqLDNnDjWN5n8aAMC0XNVMB3LPU4otV9tV8zXYt2M7q9Z0hxCq2bCQP6ogIiF");
            $token = JWT::encode($payload, $privateKey);
            return $token;
        } catch (\Exception $ex) {
            $token = false;
        }
        return $token;

    }

}
