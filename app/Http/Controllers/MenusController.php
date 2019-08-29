<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Menu;
use App\Menu_group;

class MenusController extends Controller
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
        $menus = Menu::all();

        if (!$menus) {
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditampilkan',
                'data' => $menus
            ], 200);
        }
    }

    public function store(Request $request)
    {
        // {id, menu_code, menu_name, menu_desc, menu_ref_id}
        $menu_code = $request->json()->get('menu_code');
        $menu_name = $request->json()->get('menu_name');
        $menu_desc = $request->json()->get('menu_desc');
        $menu_ref_id = $request->json()->get('menu_ref_id');

        $menus = new Menu;
        $menus->menu_code = $menu_code;
        $menus->menu_name = $menu_name;
        $menus->menu_desc = $menu_desc;
        $menus->menu_ref_id = $menu_ref_id;
        $menus->save();

        if (!$menus) {
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal ditambah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambah',
                'data' => $menus
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $menu_code = $request->json()->get('menu_code');
        $menu_name = $request->json()->get('menu_name');
        $menu_desc = $request->json()->get('menu_desc');
        $menu_ref_id = $request->json()->get('menu_ref_id');

        $menus = Menu::find($id);
        $menus->menu_code = $menu_code;
        $menus->menu_name = $menu_name;
        $menus->menu_desc = $menu_desc;
        $menus->menu_ref_id = $menu_ref_id;
        $menus->save();

        if (!$menus) {
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diubah',
                'data' => $menus
            ], 200);
        }
    }

    public function destroy($id)
    {
        $menus = Menu::find($id);
        $menus->delete();

        if (!$menus) {
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            Menu_group::where('menu_id', $id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus',
                'data' => $menus
            ], 200);
        }
    }

    public function restore()
    {
        $menus = Menu::withTrashed()->restore();

        if (!$menus) {
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal dikembalikan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dikembalikan',
                'data' => $menus
            ], 200);
        }
    }

    //
}
