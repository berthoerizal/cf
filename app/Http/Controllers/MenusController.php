<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MenusController extends Controller
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
        $menus = DB::table('menus')->get();

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

        $menus = DB::table('menus')->insert([
            'menu_code' => $menu_code,
            'menu_name' => $menu_name,
            'menu_desc' => $menu_desc,
            'menu_ref_id' => $menu_ref_id
        ]);

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

        $menus = DB::table('menus')->where('id', $id)->update([
            'menu_code' => $menu_code,
            'menu_name' => $menu_name,
            'menu_desc' => $menu_desc,
            'menu_ref_id' => $menu_ref_id
        ]);

        if (!$menus) {
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Menu berhasil diubah',
                'data' => $menus
            ], 200);
        }
    }

    public function destroy($id)
    {
        $menus = DB::table('menus')->where('id', $id)->delete();

        if (!$menus) {
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus',
                'data' => $menus
            ], 200);
        }
    }

    //
}
