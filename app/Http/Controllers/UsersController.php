<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\Authenticate;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $users = DB::table('users')->get();

        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'Users gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Users berhasil ditampilkan',
                'data' => $users
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $nama = $request->json()->get('nama');
        $email = $request->json()->get('email');
        $username = $request->json()->get('username');
        $password = $request->json()->get('password');
        $api_token = NULL;

        $users = DB::table('users')->insert([
            'nama' => $nama,
            'email' => $email,
            'username' => $username,
            'password' => Hash::make($password),
            'api_token' => $api_token
        ]);

        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'User gagal ditambah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambah',
                'data' => $users
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $nama = $request->json()->get('nama');
        $email = $request->json()->get('email');
        $username = $request->json()->get('username');
        $password = $request->json()->get('password');

        $users = DB::table('users')->where('id', $id)->update([
            'nama' => $nama,
            'email' => $email,
            'username' => $username,
            'password' => $password
        ]);

        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'User gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diubah',
                'data' => $users
            ], 200);
        }
    }

    public function delete(Request $request, $id)
    {
        $users = DB::table('users')->where('id', $id)->delete();

        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'User gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus',
                'data' => $users
            ], 200);
        }
    }



    //
}
