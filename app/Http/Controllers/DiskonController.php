<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index()
    {
        $diskon = Diskon::all();
        if($diskon->count() > 0 ){
            return response()->json([
                'status' => 200,
                'diskon' => $diskon,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data diskon tidak ditemukan',
            ], 404);
        }
    }
}
