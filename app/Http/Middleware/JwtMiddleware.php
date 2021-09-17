<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            $status = User::findOrFail($payload->get('uuid'))->status;

            if($status == '1'){
                JWTAuth::parseToken()->authenticate();
            } else {
                return response()->json(['status' => 'Token is Invalid . User InActive'],401);
                // throw new \Exception('Token is Invalid. User Inactive' , 401);
            }

        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}
