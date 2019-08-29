<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\Authenticate;

class EntitasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $index = DB::table('entitas')->get();

        if (!$index) {
            return response()->json([
                'success' => false,
                'message' => 'entitas gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'entitas berhasil ditampilkan',
                'data' => $index
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $entitas_code = $request->json()->get('entitas_code');
        $entitas_name = $request->json()->get('entitas_name');
        $entitas_desc = $request->json()->get('entitas_desc');
        $entitas_status = $request->json()->get('entitas_status');

        $store = DB::table('entitas')->insert([
            'entitas_code' => $entitas_code,
            'entitas_name' => $entitas_name,
            'entitas_desc' => $entitas_desc,
            'entitas_status' => $entitas_status
        ]);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'entitas gagal ditambah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'entitas berhasil ditambah',
                'data' => $store
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $entitas_code = $request->json()->get('entitas_code');
        $entitas_name = $request->json()->get('entitas_name');
        $entitas_desc = $request->json()->get('entitas_desc');
        $entitas_status = $request->json()->get('entitas_status');

        $update = DB::table('entitas')->where('id', $id)->update([

            'entitas_code' => $entitas_code,
            'entitas_name' => $entitas_name,
            'entitas_desc' => $entitas_desc,
            'entitas_status' => $entitas_status
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
        $delete = DB::table('entitas')->where('id', $id)->delete();

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
