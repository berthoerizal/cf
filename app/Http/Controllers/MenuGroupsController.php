<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuGroupsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('jwt.auth');
    }

    public function index()
    {
        $menu_groups = DB::table('menu_groups')->get();

        if (!$menu_groups) {
            return response()->json([
                'success' => false,
                'message' => 'Menu Groups gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Menu Groups berhasil ditampilkan',
                'data' => $menu_groups
            ], 200);
        }
    }

    public function show($id)
    {
        $menu_groups = DB::table('menu_groups')->where('admin_group_id', $id)->get();

        if (!$menu_groups) {
            return response()->json([
                'success' => false,
                'message' => 'Menu Groups gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Menu Groups berhasil ditampilkan',
                'data' => $menu_groups
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        // menu_groups {id, admin_group_id, menu_id, mgroup_status, mgroup_r, mgroup_c, mgroup_u, mgroup_d, mgroup_a}
        $mgroup_status = $request->json()->get('mgroup_status');
        $mgroup_r = $request->json()->get('mgroup_r');
        $mgroup_c = $request->json()->get('mgroup_c');
        $mgroup_u = $request->json()->get('mgroup_u');
        $mgroup_d = $request->json()->get('mgroup_d');
        $mgroup_a = $request->json()->get('mgroup_a');

        $menu_groups = DB::table('menu_groups')->where('id', $id)->update([
            'mgroup_status' => $mgroup_status,
            'mgroup_r' => $mgroup_r,
            'mgroup_c' => $mgroup_c,
            'mgroup_u' => $mgroup_u,
            'mgroup_d' => $mgroup_d,
            'mgroup_a' => $mgroup_a
        ]);

        if (!$menu_groups) {
            return response()->json([
                'success' => false,
                'message' => 'Menu Groups gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Menu Groups berhasil diubah',
                'data' => ''
            ], 200);
        }
    }

    //
}
