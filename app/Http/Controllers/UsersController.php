<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersController extends Controller
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
        $users = User::all();

        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'Users gagal ditampilkan',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Users berhasil ditampilkan',
                'data' => $users
            ], 200);
        }
    }

    public function store(Request $request)
    {
        // users {id, position_id(boleh null), username, password, api_token, user_fullname, user_email, user_phone_number, user_ktp, user_photo_ktp = photo1, user_photo = photo2}
        // $user_photo_ktp = $request->photo1;
        $user_photo_ktp = $request->file('photo1');
        $user_photo = $request->file('photo2');
        if ($user_photo_ktp || $user_photo) {

            // $exploded = explode(',', $user_photo_ktp);

            // $decoded = base64_decode($exploded[1]);

            // if (str_contains($exploded[0], 'jpeg')) {
            //     $extension = 'jpg';
            // } else {
            //     $extension = 'png';
            // }

            // $filename = time() . str_random() . '.' . $extension;
            // $path = public_path() . '/upload/image/' . $filename;

            // if (file_put_contents($path, $decoded)) {

            $filename1 = uniqid() . $user_photo_ktp->getClientOriginalName();
            $filename2 = uniqid() . $user_photo->getClientOriginalName();
            if (($user_photo_ktp->move(storage_path('') . '/../public/upload/image/', $filename1)) && ($user_photo->move(storage_path('') . '/../public/upload/image/', $filename2))) {

                $users = new User;
                $users->position_id = $request->position_id;
                $users->username = $request->username;
                $users->password = Hash::make($request->password);
                $users->api_token = NULL;
                $users->user_fullname = $request->user_fullname;
                $users->user_email = $request->user_email;
                $users->user_phone_number = $request->user_phone_number;
                $users->user_ktp = $request->user_ktp;
                $users->user_photo_ktp = $filename1;
                $users->user_photo = $filename2;
                $users->save();

                if (!$users) {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'User gagal ditambah',
                        'data'      => ''
                    ], 401);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'User berhasil ditambah',
                        'data'      => $users
                    ], 200);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Photo KTP gagal dimasukkan',
                    'data'      => ''
                ], 400);
            }
        }
    }

    public function update(Request $request, $id)
    {
        // users {id, position_id(boleh null), username, password, api_token, user_fullname, user_email, user_phone_number, user_ktp, user_photo_ktp = photo1, user_photo = photo2}

        // $user_photo_ktp = $request->photo1;

        $user_photo_ktp = $request->file('photo1');
        $user_photo = $request->file('photo2');
        if (!$user_photo && !$user_photo_ktp) {
            $users = DB::table('users')->where('id', $id)->update([
                'position_id' => $request->position_id,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'user_fullname' => $request->user_fullname,
                'user_email' => $request->user_email,
                'user_phone_number' => $request->user_phone_number,
                'user_ktp' => $request->user_ktp
            ]);

            if (!$users) {
                return response()->json([
                    'success'   => false,
                    'message'   => 'User gagal diubah',
                    'data'      => ''
                ], 500);
            } else {
                return response()->json([
                    'success'   => true,
                    'message'   => 'User berhasil diubah',
                    'data'      => $users
                ], 200);
            }
        } else {
            // $exploded = explode(',', $user_photo_ktp);

            // $decoded = base64_decode($exploded[1]);

            // if (str_contains($exploded[0], 'jpeg')) {
            //     $extension = 'jpg';
            // } else {
            //     $extension = 'png';
            // }

            // $filename = time() . str_random() . '.' . $extension;

            // $path = public_path() . '/upload/image/' . $filename;

            // if (file_put_contents($path, $decoded)) {
            $filename1 = uniqid() . $user_photo_ktp->getClientOriginalName();
            $filename2 = uniqid() . $user_photo->getClientOriginalName();
            if (($user_photo_ktp->move(storage_path('') . '/../public/upload/image/', $filename1)) && ($user_photo->move(storage_path('') . '/../public/upload/image/', $filename2))) {

                $user = DB::table('users')->where('id', $id)->first();
                $old_photo_ktp = $user->user_photo_ktp;
                $old_photo = $user->user_photo;

                $user = DB::table('users')->where('id', $id)->first();
                $old_photo_ktp = storage_path('') . '/../public/upload/image/' . $user->user_photo_ktp;
                $old_photo = storage_path('') . '/../public/upload/image/' . $user->user_photo;
                if (file_exists($old_photo_ktp) || file_exists($old_photo)) {
                    @unlink($old_photo_ktp);
                    @unlink($old_photo);
                }

                $users = User::find($id);
                $users->position_id = $request->position_id;
                $users->username = $request->username;
                $users->password = Hash::make($request->password);
                $users->user_fullname = $request->user_fullname;
                $users->user_email = $request->user_email;
                $users->user_phone_number = $request->user_phone_number;
                $users->user_ktp = $request->user_ktp;
                $users->user_photo_ktp = $filename1;
                $users->user_photo = $filename2;
                $users->save();

                if (!$users) {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'User gagal diubah',
                        'data'      => ''
                    ], 401);
                } else {
                    return response()->json([
                        'success'   => true,
                        'message'   => 'User berhasil diubah',
                        'data'      => $users
                    ], 200);
                }
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Gambar gagal diubah',
                    'data'      => ''
                ], 400);
            }
        }
    }

    public function delete($id)
    {

        $user = DB::table('users')->where('id', $id)->first();
        $old_photo_ktp = storage_path('') . '/../public/upload/image/' . $user->user_photo_ktp;
        $old_photo = storage_path('') . '/../public/upload/image/' . $user->user_photo;
        if (file_exists($old_photo_ktp) || file_exists($old_photo)) {
            @unlink($old_photo_ktp);
            @unlink($old_photo);
        }

        $users = DB::table('users')->where('id', $id)->delete();

        if (!$users) {
            return response()->json([
                'success' => false,
                'message' => 'User gagal dihapus',
                'data' => ''
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus',
                'data' => $users
            ], 200);
        }
    }



    //
}
