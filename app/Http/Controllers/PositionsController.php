<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\Authenticate;

class PositionsController extends Controller
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
        $index = DB::table('positions')
            ->join('departemens', 'positions.departemen_id', '=', 'departemens.id')
            ->select('positions.*', 'departemens.id as departemen_id')
            ->get();

        if (!$index) {
            return response()->json([
                'success' => false,
                'message' => 'positions gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'positions berhasil ditampilkan',
                'data' => $index
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $departemen_id = $request->json()->get('departemen_id');
        $position_name = $request->json()->get('position_name');
        $position_desc = $request->json()->get('position_desc');
        $position_status = $request->json()->get('position_status');

        $store = DB::table('positions')->insert([
            'departemen_id' => $departemen_id,
            'position_name' => $position_name,
            'position_desc' => $position_desc,
            'position_status' => $position_status
        ]);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'positions gagal ditambah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'positions berhasil ditambah',
                'data' => $store
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $departemen_id = $request->json()->get('departemen_id');
        $position_name = $request->json()->get('position_name');
        $position_desc = $request->json()->get('position_desc');
        $position_status = $request->json()->get('position_status');

        $update = DB::table('positions')->where('id', $id)->update([
            'departemen_id' => $departemen_id,
            'position_name' => $position_name,
            'position_desc' => $position_desc,
            'position_status' => $position_status
        ]);

        if (!$update) {
            return response()->json([
                'success' => false,
                'message' => 'positions gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'positions berhasil diubah',
                'data' => $update
            ], 200);
        }
    }

    public function destroy($id)
    {
        $delete = DB::table('positions')->where('id', $id)->delete();

        if (!$delete) {
            return response()->json([
                'success' => false,
                'message' => 'positions gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'positions berhasil dihapus',
                'data' => $delete
            ], 200);
        }
    }
}
