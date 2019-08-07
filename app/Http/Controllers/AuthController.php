<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function postLogin(Request $request)
    {
        try {

            if (!$token = $this->jwt->attempt($request->only('username', 'password'))) {
                return response()->json(['user_not_found'], 404);
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
}
