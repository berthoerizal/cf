<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\Authenticate;

class ProjectsController extends Controller
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
        $index = DB::table('projects')
            // ->join('admins', 'projects.admin_id', '=', 'admins.id')
            // ->select('projects.*', 'admins.id as admin_id')
            ->get();

        if (!$index) {
            return response()->json([
                'success' => false,
                'message' => 'projects gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'projects berhasil ditampilkan',
                'data' => $index
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $admin_id = $request->json()->get('admin_id');
        $project_name = $request->json()->get('project_name');
        $project_desc =  $request->json()->get('project_desc');
        $project_short_desc = $request->json()->get('project_short_desc');
        $project_min_modal = $request->json()->get('project_min_modal');
        $project_sharingp = $request->json()->get('project_sharingp');
        $project_total =  $request->json()->get('project_total');
        $project_date = $request->json()->get('project_date');
        $project_duration = $request->json()->get('project_duration');
        $project_start_date = $request->json()->get('project_start_date');
        $project_status = $request->json()->get('project_status');

        $store = DB::table('projects')->insert([
            'admin_id' => $admin_id,
            'project_name' => $project_name,
            'project_desc' => $project_desc,
            'project_short_desc' => $project_short_desc,
            'project_min_modal' => $project_min_modal,
            'project_sharingp' => $project_sharingp,
            'project_total' => $project_total,
            'project_date' => $project_date,
            'project_duration' => $project_duration,
            'project_start_date' => $project_start_date,
            'project_status' =>  $project_status
        ]);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'projects gagal ditambah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'projects berhasil ditambah',
                'data' => $store
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $admin_id = $request->json()->get('admin_id');
        $project_name = $request->json()->get('project_name');
        $project_desc =  $request->json()->get('project_desc');
        $project_short_desc = $request->json()->get('project_short_desc');
        $project_min_modal = $request->json()->get('project_min_modal');
        $project_sharingp = $request->json()->get('project_sharingp');
        $project_total =  $request->json()->get('project_total');
        $project_date = $request->json()->get('project_date');
        $project_duration = $request->json()->get('project_duration');
        $project_start_date = $request->json()->get('project_start_date');
        $project_status = $request->json()->get('project_status');

        $update = DB::table('projects')->where('id', $id)->update([
            'admin_id' => $admin_id,
            'project_name' => $project_name,
            'project_desc' => $project_desc,
            'project_short_desc' => $project_short_desc,
            'project_min_modal' => $project_min_modal,
            'project_sharingp' => $project_sharingp,
            'project_total' => $project_total,
            'project_date' => $project_date,
            'project_duration' => $project_duration,
            'project_start_date' => $project_start_date,
            'project_status' =>  $project_status
        ]);

        if (!$update) {
            return response()->json([
                'success' => false,
                'message' => 'projects gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'projects berhasil diubah',
                'data' => $update
            ], 200);
        }
    }

    public function destroy($id)
    {
        $delete = DB::table('projects')->where('id', $id)->delete();

        if (!$delete) {
            return response()->json([
                'success' => false,
                'message' => 'projects gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'projects berhasil dihapus',
                'data' => $delete
            ], 200);
        }
    }
}