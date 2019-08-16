<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\Authenticate;

class InstallmentsController extends Controller
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
        $index = DB::table('installments')
            // ->join('admins', 'projects.admin_id', '=', 'admins.id')
            // ->select('projects.*', 'admins.id as admin_id')
            ->get();

        if (!$index) {
            return response()->json([
                'success' => false,
                'message' => 'installments gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'installments berhasil ditampilkan',
                'data' => $index
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $invest_id = $request->json()->get('invest_id');
        $i_no = $request->json()->get('i_no');
        $i_principal =  $request->json()->get('i_principal');
        $i_sprofit = $request->json()->get('i_sprofit');
        $i_total = $request->json()->get('i_total');
        $i_remaining = $request->json()->get('i_remaining');
        $i_date =  $request->json()->get('i_date');
        $i_date_pay = $request->json()->get('i_date_pay');
        $i_status = $request->json()->get('i_status');
        
        $store = DB::table('installments')->insert([
            'invest_id' => $invest_id,
            'i_no' => $i_no,
            'i_principal' => $i_principal,
            'i_sprofit' => $i_sprofit,
            'i_total' => $i_total,
            'i_remaining' => $i_remaining,
            'i_date' => $i_date,
            'i_date_pay' => $i_date_pay,
            'i_status' => $i_status
        ]);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'installments gagal ditambah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'installments berhasil ditambah',
                'data' => $store
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $invest_id = $request->json()->get('invest_id');
        $i_no = $request->json()->get('i_no');
        $i_principal =  $request->json()->get('i_principal');
        $i_sprofit = $request->json()->get('i_sprofit');
        $i_total = $request->json()->get('i_total');
        $i_remaining = $request->json()->get('i_remaining');
        $i_date =  $request->json()->get('i_date');
        $i_date_pay = $request->json()->get('i_date_pay');
        $i_status = $request->json()->get('i_status');

        $update = DB::table('installments')->where('id', $id)->update([
            'invest_id' => $invest_id,
            'i_no' => $i_no,
            'i_principal' => $i_principal,
            'i_sprofit' => $i_sprofit,
            'i_total' => $i_total,
            'i_remaining' => $i_remaining,
            'i_date' => $i_date,
            'i_date_pay' => $i_date_pay,
            'i_status' => $i_status
        ]);

        if (!$update) {
            return response()->json([
                'success' => false,
                'message' => 'installments gagal diubah',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'installments berhasil diubah',
                'data' => $update
            ], 200);
        }
    }

    public function destroy($id)
    {
        $delete = DB::table('installments')->where('id', $id)->delete();

        if (!$delete) {
            return response()->json([
                'success' => false,
                'message' => 'installments gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'installments berhasil dihapus',
                'data' => $delete
            ], 200);
        }
    }
}