<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Facebook;

class FacebookController extends Controller
{
    public function index()
    {
        $facebook = Facebook::all();

        if($facebook->count() > 0) {
            return response()->json([
                'status' => 200,
                'facebook' => $facebook,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data facebook user tidak ditemukan',
            ], 404);
        }
    }

    public function show()
    {
        $facebook = Facebook::orderBy('tanggal_masuk', 'desc')->first();

        if($facebook) {
            return response()->json([
                'status' => 200,
                'facebook' => $facebook,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data facebook user tidak ditemukan',
            ], 404);
        }
    }
}
