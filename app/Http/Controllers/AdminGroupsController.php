<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGroupsController extends Controller
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
        $admin_groups = DB::table('admin_groups')->get();

        if (!$admin_groups) {
            return response()->json([
                'success' => false,
                'message' => 'Admin Group gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Admin Group berhasil ditampilkan',
                'data' => $admin_groups
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $group_name = $request->json()->get('group_name');
        $group_desc = $request->json()->get('group_desc');

        $menus_count = DB::table('menus')->count();
        $menusJSON = DB::table('menus')->get();
        $menusArray = json_decode($menusJSON, true);

        $admin_groups = DB::table('admin_groups')->insertGetId([
            'group_name' => $group_name,
            'group_desc' => $group_desc
        ]);

        if (!$admin_groups) {
            return response()->json([
                'success' => false,
                'message' => 'Admin Group gagal ditambah',
                'data' => ''
            ], 401);
        } else {
            // menu_groups {id, admin_group_id, menu_id, mgroup_status, mgroup_r, mgroup_c, mgroup_u, mgroup_d, mgroup_a}
            $mgroup_status = $mgroup_r = $mgroup_c = $mgroup_u = $mgroup_d = $mgroup_a = false;
            for ($x = 0; $x < $menus_count; $x++) {
                DB::table('menu_groups')->insert([
                    'admin_group_id' => $admin_groups,
                    'menu_id' => $menusArray[$x]["id"],
                    'mgroup_status' => $mgroup_status,
                    'mgroup_r' => $mgroup_r,
                    'mgroup_c' => $mgroup_c,
                    'mgroup_u' => $mgroup_u,
                    'mgroup_d' => $mgroup_d,
                    'mgroup_a' => $mgroup_a
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Admin Group berhasil ditambah',
                'data' => $admin_groups
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $group_name = $request->json()->get('group_name');
        $group_desc = $request->json()->get('group_desc');

        $admin_groups = DB::table('admin_groups')->where('id', $id)->update([
            'group_name' => $group_name,
            'group_desc' => $group_desc
        ]);

        if (!$admin_groups) {
            return response()->json([
                'success' => false,
                'message' => 'Admin Group gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Admin Group berhasil diubah',
                'data' => $admin_groups
            ], 200);
        }
    }

    public function destroy($id)
    {
        $admin_groups = DB::table('admin_groups')->where('id', $id)->delete();

        if (!$admin_groups) {
            return response()->json([
                'success' => false,
                'message' => 'Admin Group gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            DB::table('menu_groups')->where('admin_group_id', $id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Admin Group berhasil dihapus',
                'data' => $admin_groups
            ], 200);
        }
    }

    //
}
