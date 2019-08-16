<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Admin_group;
use App\Menu_group;
use App\Menu;

class AdminGroupsController extends Controller
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
        $admin_groups = Admin_group::all();

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

        $menus_count = Menu::all()->count();
        $menusJSON = Menu::all();
        $menusArray = json_decode($menusJSON, true);

        $admin_groups = new Admin_group;
        $admin_groups->group_name = $group_name;
        $admin_groups->group_desc = $group_desc;
        $admin_groups->save();

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
                $menu_groups = new Menu_group;
                $menu_groups->admin_group_id = $admin_groups->id;
                $menu_groups->menu_id = $menusArray[$x]["id"];
                $menu_groups->mgroup_status = $mgroup_status;
                $menu_groups->mgroup_c = $mgroup_c;
                $menu_groups->mgroup_r = $mgroup_r;
                $menu_groups->mgroup_u = $mgroup_u;
                $menu_groups->mgroup_d = $mgroup_d;
                $menu_groups->mgroup_a = $mgroup_a;
                $menu_groups->save();
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

        $admin_groups = Admin_group::find($id);
        $admin_groups->group_name = $group_name;
        $admin_groups->group_desc = $group_desc;
        $admin_groups->save();

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
        $admin_groups = Admin_group::find($id)->delete();

        if (!$admin_groups) {
            return response()->json([
                'success' => false,
                'message' => 'Admin Group gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            Menu_group::where('admin_group_id', $id)->delete();
            DB::table('admins')->where('group_id', $id)->update([
                'group_id' => NULL
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Admin Group berhasil dihapus',
                'data' => $admin_groups
            ], 200);
        }
    }

    //
}
