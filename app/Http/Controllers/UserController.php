<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();

        if($user->count() > 0) {
            return response()->json([
                'status' => 200,
                'User' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data user tidak ditemukan',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $user = User::create([
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'password' => $request->password,
            ]);
    
            if($user) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data user berhasil ditambahkan',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Data user gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        if($user) {
            return response()->json([
                'status' => 200,
                'User' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data user tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'string',
            'email' => 'string',
            'password' => 'string',
            'gambar' => 'string',
            'nama_lengkap' => 'string',
            'nomor_hp' => 'string',
            'alamat' => 'text',
            'role' => 'string',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $user = User::find($id);

            if($user) {
                $user->fill($request->only([
                    'nama_pengguna',
                    'email',
                    'password',
                    'gambar',
                    'nama_lengkap',
                    'nomor_hp',
                    'alamat',
                    'role',
                ]));
            
                $user->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data user berhasil diupdate',
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data user tidak ditemukan',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if($user) {
            $user->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data user berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data user tidak ditemukan',
            ], 404);
        }
    }
}
