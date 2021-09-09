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


    public function authenticate()
    {
        $existing_token = Auth::user()->jwt_token;
        try {

            if($existing_token){
                JWTAuth::setToken($existing_token)->invalidate();
                $token = JWTAuth::fromUser(Auth::user());
            } else  {
                $token = JWTAuth::fromUser(Auth::user());
                if(!$token){
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }

                $user = User::find(Auth::user()->id);
                $user->jwt_token = $token;
                $user->save();
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));

    }


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
