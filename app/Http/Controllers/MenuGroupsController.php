<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Menu_group;

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
        $menu_groups = Menu_group::all();

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
        $menu_groups = Menu_group::where('admin_group_id', $id)->get();

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

        $menu_groups = Menu_group::find($id);
        $menu_groups->mgroup_status = $mgroup_status;
        $menu_groups->mgroup_r = $mgroup_r;
        $menu_groups->mgroup_c = $mgroup_c;
        $menu_groups->mgroup_u = $mgroup_u;
        $menu_groups->mgroup_d = $mgroup_d;
        $menu_groups->mgroup_a = $mgroup_a;
        $menu_groups->save();

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
