<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Google;
use App\Models\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

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

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengguna' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'kode_referensi' => 'nullable|string|exists:users,kode',
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

            if ($request->filled('kode_referensi')) {
                $referencedUser = User::where('kode', $request->kode_referensi)->first();
                if ($referencedUser) {
                    $referencedUser->point += 1000;
                    $referencedUser->save();

                    $user->point += 2000;
                    $user->save();
                } else {
                    return response()->json([
                        'status' => 422,
                        'errors' => ['kode_referensi' => ['Kode referensi tidak valid.']],
                    ], 422);
                }
            }

            $token = $user->createToken('auth_token')->plainTextToken;
    
            if($user) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Register successful',
                    'access_token' => $token,
                    'user' => [
                        "id" => $user->id,
                        "gambar" => null,
                        "nama_pengguna" => $user->nama_pengguna,
                        "nama_lengkap" => null,
                        "email" => $user->email,
                        "password" => $hashedPassword,
                        "google_id" => null,
                        "facebook_id" => null,
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

    private function generateRandomPassword($length = 15)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $password;
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            $googleRedirectUri = Config::get('services.login.redirect');

            if (!$user) {
                $randomPassword = $this->generateRandomPassword(15);
                $hashedPassword = Hash::make($randomPassword);

                $user = User::create([
                    'gambar' => $googleUser->getAvatar(),
                    'nama_pengguna' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => $hashedPassword,
                    'google_id' => $googleUser->getId(),
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;

                $google = Google::create([
                    'access_token' => $token,
                    'pengguna_id' => $user->id,
                    'tanggal_masuk' => now(),
                ]);

                return redirect($googleRedirectUri.'/login/google')->with([
                    'status' => 200,
                    'message' => 'Register account google successful',
                    'access_token' => $token,
                    'user' => [
                        "id" => $user->id,
                        "gambar" => $user->gambar,
                        "nama_pengguna" => $user->nama_pengguna,
                        "nama_lengkap" => null,
                        "email" => $user->email,
                        "password" => $hashedPassword,
                        "google_id" => $user->google_id,
                        "facebook_id" => null,
                        "nomor_hp" => null,
                        "alamat" => null,
                        "peran" => "user",
                        "kode" => $user->kode,
                        "point" => $user->point,
                        "created_at" => $user->created_at,
                        "updated_at" => $user->updated_at
                    ],
                ], 200);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            $google = Google::where('pengguna_id', $user->id)->first();

            if ($google) {
                $google->access_token = $token;
                $google->tanggal_masuk = now();
                $google->save();
            }

            return redirect($googleRedirectUri.'/login/google')->with([
                'status' => 200,
                'message' => 'Login account google successful',
                'access_token' => $token,
                'user' => $user,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to login, try again later.'], 500);
        }
    }


    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $user = User::where('email', $facebookUser->getEmail())->first();

            $facebookRedirectUri = Config::get('services.login.redirect');

            if (!$user) {
                $randomPassword = $this->generateRandomPassword(15);
                $hashedPassword = Hash::make($randomPassword);

                $user = User::create([
                    'gambar' => $facebookUser->getAvatar(),
                    'nama_pengguna' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'password' => $hashedPassword,
                    'facebook_id' => $facebookUser->getId(),
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;

                $facebook = Facebook::create([
                    'access_token' => $token,
                    'pengguna_id' => $user->id,
                    'tanggal_masuk' => now(),
                ]);

                return redirect($facebookRedirectUri.'/login/facebook')->with([
                    'status' => 200,
                    'message' => 'Register account facebook successful',
                    'access_token' => $token,
                    'user' => [
                        "id" => $user->id,
                        "gambar" => $user->gambar,
                        "nama_pengguna" => $user->nama_pengguna,
                        "nama_lengkap" => null,
                        "email" => $user->email,
                        "password" => $hashedPassword,
                        "google_id" => null,
                        "facebook_id" => $user->facebook_id,
                        "nomor_hp" => null,
                        "alamat" => null,
                        "peran" => "user",
                        "kode" => $user->kode,
                        "point" => $user->point,
                        "created_at" => $user->created_at,
                        "updated_at" => $user->updated_at
                    ],
                ], 200);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            $facebook = Facebook::where('pengguna_id', $user->id)->first();

            if ($facebook) {
                $facebook->access_token = $token;
                $facebook->tanggal_masuk = now();
                $facebook->save();
            }

            return redirect($facebookRedirectUri.'/login/facebook')->with([
                'status' => 200,
                'message' => 'Login account facebook successful',
                'access_token' => $token,
                'user' => $user,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to login, try again later.'], 500);
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
                        "google_id" => null,
                        "facebook_id" => null,
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
            'gambar' => 'file|image|max:2048',
            'nama_pengguna' => 'string',
            'nama_lengkap' => 'string',
            'nomor_hp' => 'string',
            'alamat' => 'string',
            'peran' => 'string',
            'point' => 'int',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $user = User::find($id);

            if($user) {
                if ($request->hasFile('gambar')) {
                    if ($user->gambar) {
                        Storage::disk('public')->delete($user->gambar);
                    }
                    $user->gambar = $request->file('gambar')->store('images', 'public');
                }

                $user->fill($request->only([
                    'nama_pengguna',
                    'nama_lengkap',
                    'nomor_hp',
                    'alamat',
                    'peran',
                    'point',
                ]));
            
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

    public function updateAccount(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'string|email|unique:users,email,'.$id,
            'password' => 'string',
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
                    'email',
                    'password',
                ]));

                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
            
                $user->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data akun user berhasil diupdate',
                    'user' => $user,
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data akun user tidak ditemukan',
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
