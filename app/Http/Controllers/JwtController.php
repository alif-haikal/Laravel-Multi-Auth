<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Traits\ResponseHandler;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use App\User;

class JwtController extends Controller
{
    use ResponseHandler;

    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
        $this->middleware('auth');
    }

    /*
    curl -X GET \
    -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvZ2VuZXJhdGVfdG9rZW4iLCJpYXQiOjE2MzExNzg1MzEsImV4cCI6MTYzMTE4MjEzMSwibmJmIjoxNjMxMTc4NTMxLCJqdGkiOiJNdE5GNHozSHBER21BUUxOIiwic3ViIjoyLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIiwidXVpZCI6Mn0.-nUo73KqQ_M-9xwBUnP-_bo2mngPNi1s4cvdbkcRPgI" \
    127.0.0.1:8000/api/closed
    */

    public function authenticate()
    {
        //if status 1 then create
        try {
            switch (Auth::user()->status) {
                case '1':
                    $payloadable = [
                        'uuid' => Auth::user()->id,
                    ];

                    $token = JWTAuth::claims($payloadable)->fromUser(Auth::user() , $payloadable);
                    if(!$token){
                        return response()->json(['error' => 'invalid_credentials'], 400);
                    }
                    break;

                default:
                    return response()->json(['error' => 'account_status_inactive'], 400);
                    break;
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    //this function specific 1 user 1 key
    // public function authenticate()
    // {
    //     $existing_token = Auth::user()->jwt_token;
    //     try {

    //         if($existing_token){
    //             JWTAuth::setToken($existing_token)->invalidate();
    //             $token = JWTAuth::fromUser(Auth::user());
    //         } else  {
    //             $token = JWTAuth::fromUser(Auth::user());
    //             if(!$token){
    //                 return response()->json(['error' => 'invalid_credentials'], 400);
    //             }

    //             $user = User::find(Auth::user()->id);
    //             $user->jwt_token = $token;
    //             $user->save();
    //         }
    //     } catch (JWTException $e) {
    //         return response()->json(['error' => 'could_not_create_token'], 500);
    //     }

    //     return response()->json(compact('token'));

    // }


    // public function authenticate(Request $request)
    // {

    //     $credentials = $request->only('email', 'password');

    //     try {
    //         if (! $token = JWTAuth::attempt($credentials)) {
    //             return response()->json(['error' => 'invalid_credentials'], 400);
    //         }
    //     } catch (JWTException $e) {
    //         return response()->json(['error' => 'could_not_create_token'], 500);
    //     }

    //     return response()->json(compact('token'));
    // }

    public function getAuthenticatedUser()
        {
            try {
                if (! $user = JWTAuth::parseToken()->authenticate()) {
                        return response()->json(['user_not_found'], 404);
                }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    return response()->json(['token_expired'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                    return response()->json(['token_invalid'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                    return response()->json(['token_absent'], $e->getStatusCode());
            }
            return response()->json(compact('user'));
        }

}
