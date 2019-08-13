<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }

    public function postLogin(Request $request)
    {
        $username = $request->json()->get('username');
        $password = $request->json()->get('password');

        try {
            $user_login = ['username' => $username, 'password' => $password];
            if (!$token = $this->jwt->attempt($user_login)) {
                return response()->json(['user_not_found'], 404);
            } else {
                $user = User::where('username', $username)->first();
                $user->update([
                    'api_token' => $token
                ]);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);
        }

        return response()->json(compact('token'));
    }

    public function postLogout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
