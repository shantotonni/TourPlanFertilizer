<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $privateKey = env("JWT_SECRET",'xn7LDJq8JYHgqrP3PkA1BSVA3cRlm8UCgP6UO1mSlIX7IWzzQWHTycpZfZa7bTRl');
            $token = $request->bearerToken();
            if($token == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authorization token required'
                ],401);
            }
            try {

                //$payload = JWT::decode($token,$privateKey,['HS256']);
                //return $payload;
//                session()->put('user_info',[
//                    'UserId' => $payload->UserId ?? '',
//                    'UserName' => $payload->UserName ?? '',
//                    'JoiningDate' => $payload->JoiningDate ?? '',
//                    'Designation' => $payload->Designation ?? '',
//                    'DefaultBusiness' => $payload->DefaultBusiness ?? '',
//                    'UserLocation' => $payload->UserLocation ?? ''
//                ]);
            } catch (\Exception $ex) {
                return response()->json([
                    'status' => 'error',
                    'message' => $ex->getMessage()
                ],500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'Authorization Token not found'], 401);
        }

        return $next($request);
    }
}


