<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\Authenticate;

class DepartemensController extends Controller
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
        $index = DB::table('departemens')->get();

        if (!$index) {
            return response()->json([
                'success' => false,
                'message' => 'departemens gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'departemens berhasil ditampilkan',
                'data' => $index
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $departemen_code = $request->json()->get('departemen_code');
        $departemen_name = $request->json()->get('departemen_name');
        $departemen_desc = $request->json()->get('departemen_desc');
        $departemen_status = $request->json()->get('departemen_status');

        $store = DB::table('departemens')->insert([
            'departemen_code' => $departemen_code,
            'departemen_name' => $departemen_name,
            'departemen_desc' => $departemen_desc,
            'departemen_status' => $departemen_status
        ]);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'departemen gagal ditambah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'departemen berhasil ditambah',
                'data' => $store
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $departemen_code = $request->json()->get('departemen_code');
        $departemen_name = $request->json()->get('departemen_name');
        $departemen_desc = $request->json()->get('departemen_desc');
        $departemen_status = $request->json()->get('departemen_status');

        $update = DB::table('departemens')->where('id', $id)->update([
            'departemen_code' => $departemen_code,
            'departemen_name' => $departemen_name,
            'departemen_desc' => $departemen_desc,
            'departemen_status' => $departemen_status
        ]);

        if (!$update) {
            return response()->json([
                'success' => false,
                'message' => 'entitas gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'entitas berhasil diubah',
                'data' => $update
            ], 200);
        }
    }

    public function destroy($id)
    {
        $delete = DB::table('departemens')->where('id', $id)->delete();

        if (!$delete) {
            return response()->json([
                'success' => false,
                'message' => 'entitas gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'entitas berhasil dihapus',
                'data' => $delete
            ], 200);
        }
    }
}
