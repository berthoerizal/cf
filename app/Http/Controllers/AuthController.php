<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Admin;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',  ['except' => ['login']]);
    }

    public function logout(Request $request)
    {
        $api_token = $request->json()->get('api_token');

        $user = User::where('api_token', $api_token)->first();

        if (!$user) {
            $admin = Admin::where('api_token', $api_token)->first();
            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Logout gagal',
                    'data' => ''
                ], 400);
            } else {
                $admin->api_token = NULL;
                $admin->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Logout admin berhasil',
                    'data' => ''
                ], 200);
            }
        } else {
            $user->api_token = NULL;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'Logout user berhasil',
                'user' => ''
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $username = $request->json()->get('username');
        $password = $request->json()->get('password');

        $validator = Validator::make(
            [
                'username' => $username,
                'password' => $password
            ],
            [
                'username' => 'required',
                'password' => 'required|min:6|max:12',
            ]
        );

        if ($validator->fails()) {
            // The given data did not pass validation
            return response()->json($validator->errors(), 422);
        } else {
            $user = User::where('username', $username)->first();

            if (!$user) {
                $admin = Admin::where('username', $username)->first();
                if (Hash::check($password, $admin->password)) {
                    $apiToken = base64_encode(str_random(40));

                    $admin->update([
                        'api_token' => $apiToken
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Login admin Berhasil',
                        'admin' => $admin
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Login Gagal',
                        'data' => ''
                    ], 400);
                }
            } else {

                if (Hash::check($password, $user->password)) {
                    $apiToken = base64_encode(str_random(40));

                    $user->update([
                        'api_token' => $apiToken
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Login user Berhasil',
                        'user' => $user
                    ], 201);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Login Gagal',
                        'data' => ''
                    ], 400);
                }
            }
        }
    }
}
