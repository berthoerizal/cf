<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\Authenticate;

class InvestsController extends Controller
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
        $index = DB::table('invests')
            // ->join('projects', 'invests.project_id', '=', 'projects.id')
            // ->join('users', 'invest.user_id', '=', 'users.id')
            // ->select('invests.*', 'projects.id as project_id', 'users.id as user_id')
            ->get();

        if(!$index){
            return response()->json([
                'success' => false,
                'message' => 'invests gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'invest berhasil ditampilkan',
                'data' => $index
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $project_id = $request->json()->get('project_id');
        $user_id    = $request->json()->get('user_id');
        $invest_paid_capital = $request->json()->get('invest_paid_capital');
        $invest_duration = $request->json()->get('invest_duration');
        
        $store = DB::table('invests')->insert([
            'project_id' => $project_id,
            'user_id' => $user_id,
            'invest_paid_capital' => $invest_paid_capital,
            'invest_duration' => $invest_duration
        ]);

        if(!$store){
            return response()->json([
                'success' => false,
                'message' => 'invest gagal ditambahkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'invest berhasil ditambahkan',
                'data' => $store
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $project_id = $request->json()->get('project_id');
        $user_id    = $request->json()->get('user_id');
        $invest_paid_capital = $request->json()->get('invest_paid_capital');
        $invest_duration = $request->json()->get('invest_duration');

        $update = DB::table('invests')->where('id', $id)->update([
            'project_id' => $project_id,
            'user_id' => $user_id,
            'invest_paid_capital' => $invest_paid_capital,
            'invest_duration' => $invest_duration
        ]);

        if (!$update) {
            return response()->json([
                'success' => false,
                'message' => 'invest gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'invest berhasil diubah',
                'data' => $update
            ], 200);
        }
    }

    public function destroy($id)
    {
        $delete = DB::table('invests')->where('id', $id)->delete();

        if (!$delete) {
            return response()->json([
                'success' => false,
                'message' => 'invest gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'invest berhasil dihapus',
                'data' => $delete
            ], 200);
        }
    }
}