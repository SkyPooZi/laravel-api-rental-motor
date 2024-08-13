<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Google;

class GoogleController extends Controller
{
    public function index()
    {
        $google = Google::all();

        if($google->count() > 0) {
            return response()->json([
                'status' => 200,
                'google' => $google,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data google user tidak ditemukan',
            ], 404);
        }
    }

    public function show()
    {
        $google = Google::orderBy('tanggal_masuk', 'desc')->first();

        if($google) {
            return response()->json([
                'status' => 200,
                'google' => $google,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data google user tidak ditemukan',
            ], 404);
        }
    }
}
