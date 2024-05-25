<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();

        if($user->count() > 0) {
            return response()->json([
                'status' => 200,
                'user' => $user,
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
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $hashedPassword = Hash::make($request->password);

            $user = User::create([
                'nama_pengguna' => $request->nama_pengguna,
                'email' => $request->email,
                'password' => $hashedPassword,
            ]);
    
            if($user) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data user berhasil ditambahkan',
                    'user' => [
                        "id" => $user->id,
                        "gambar" => null,
                        "nama_pengguna" => $user->nama_pengguna,
                        "nama_lengkap" => null,
                        "email" => $user->email,
                        "password" => $hashedPassword,
                        "nomor_hp" => null,
                        "alamat" => null,
                        "peran" => "user",
                        "kode" => $user->kode,
                        "point" => $user->point,
                        "created_at" => $user->created_at,
                        "updated_at" => $user->updated_at
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Data user gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid email',
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Invalid password',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'access_token' => $token,
            'user' => $user,
        ], 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if($user) {
            return response()->json([
                'status' => 200,
                'user' => $user,
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
            'gambar' => 'string',
            'nama_pengguna' => 'string',
            'nama_lengkap' => 'string',
            'email' => 'string|email|unique:users,email,'.$id,
            'password' => 'string',
            'nomor_hp' => 'string',
            'alamat' => 'string',
            'peran' => 'string',
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
                    'gambar',
                    'nama_pengguna',
                    'nama_lengkap',
                    'email',
                    'password',
                    'nomor_hp',
                    'alamat',
                    'peran',
                ]));

                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
            
                $user->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data user berhasil diupdate',
                    'user' => $user,
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
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data user tidak ditemukan',
            ], 404);
        }
    }
}
