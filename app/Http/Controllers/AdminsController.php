<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
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
        $admins = DB::table('admins')->get();

        if (!$admins) {
            return response()->json([
                'success' => false,
                'message' => 'Admin gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil ditampilkan',
                'data' => $admins
            ], 200);
        }
    }

    public function store(Request $request)
    {
        // admins {id, group_id, username, password, api_token, admin_email, admin_name, admin_phone_number}
        $group_id = NULL;
        $api_token = NULL;
        $username = $request->json()->get('username');
        $password = $request->json()->get('password');
        $admin_email = $request->json()->get('admin_email');
        $admin_name = $request->json()->get('admin_name');
        $admin_phone_number = $request->json()->get('admin_phone_number');

        $admins = DB::table('admins')->insert([
            'group_id' => $group_id,
            'api_token' => $api_token,
            'username' => $username,
            'password' => Hash::make($password),
            'admin_email' => $admin_email,
            'admin_name' => $admin_name,
            'admin_phone_number' => $admin_phone_number
        ]);

        if (!$admins) {
            return response()->json([
                'success' => false,
                'message' => 'Admin gagal ditambah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil ditambah',
                'data' => $admins
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $username = $request->json()->get('username');
        $password = $request->json()->get('password');
        $admin_email = $request->json()->get('admin_email');
        $admin_name = $request->json()->get('admin_name');
        $admin_phone_number = $request->json()->get('admin_phone_number');

        $admins = DB::table('admins')->where('id', $id)->update([
            'username' => $username,
            'password' => Hash::make($password),
            'admin_email' => $admin_email,
            'admin_name' => $admin_name,
            'admin_phone_number' => $admin_phone_number
        ]);

        if (!$admins) {
            return response()->json([
                'success' => false,
                'message' => 'Admin gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil diubah',
                'data' => $admins
            ], 200);
        }
    }

    public function destroy($id)
    {
        $admins = DB::table('admins')->where('id', $id)->delete();

        if (!$admins) {
            return response()->json([
                'success' => false,
                'message' => 'Admin gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil dihapus',
                'data' => $admins
            ], 200);
        }
    }

    //
}
