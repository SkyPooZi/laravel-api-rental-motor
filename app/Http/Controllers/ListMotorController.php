<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ListMotor;
use Illuminate\Http\Request;

class ListMotorController extends Controller
{
    public function index()
    {
        $listMotor = ListMotor::all();
        if($listMotor->count() > 0 ){
            return response()->json([
                'status' => 200,
                'ListMotor' => $listMotor,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data motor tidak ditemukan',
            ], 404);
        }
    }
}
