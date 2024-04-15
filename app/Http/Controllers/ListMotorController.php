<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ListMotor;
use Illuminate\Http\Request;
use Validator;

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipe_motor' => 'required|string|max:191',
            'merk_motor' => 'required|string|max:191|',
            'nama_motor' => 'required|string|max:191',
            'stok_motor' => 'required|int',
            'status_motor' => 'required|string|max:191',
            'harga_motor_per_1_hari' => 'required|int',
            'harga_motor_per_1_minggu' => 'required|int',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
                
                $listMotor = ListMotor::create([
                    'tipe_motor' => $request->tipe_motor,
                    'merk_motor' => $request->merk_motor,
                    'nama_motor' => $request->nama_motor,
                    'stok_motor' => $request->stok_motor,
                    'status_motor' => $request->status_motor,
                    'harga_motor_per_1_hari' => $request->harga_motor_per_1_hari,
                    'harga_motor_per_1_minggu' => $request->harga_motor_per_1_minggu,
                ]);
    
                if($listMotor){
                    return response()->json([
                        'status' => 200,
                        'message' => 'Data motor berhasil ditambahkan',
                    ], 200);
                }else{
                    return response()->json([
                        'status' => 500,
                        'message' => 'Data motor gagal ditambahkan',
                    ], 500);
                }
            }
        
    }

    public function show($id)
    {
        $listMotor = ListMotor::find($id);
        if($listMotor){
            return response()->json([
                'status' => 200,
                'ListMotor' => $listMotor,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data motor tidak ditemukan',
            ], 404);
        }
    }

    public function edit($id)
    {
        $listMotor = ListMotor::find($id);
        if($listMotor){
            return response()->json([
                'status' => 200,
                'ListMotor' => $listMotor,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data motor tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'tipe_motor' => 'required|string|max:191',
            'merk_motor' => 'required|string|max:191|',
            'nama_motor' => 'required|string|max:191',
            'stok_motor' => 'required|int',
            'status_motor' => 'required|string|max:191',
            'harga_motor_per_1_hari' => 'required|int',
            'harga_motor_per_1_minggu' => 'required|int',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $listMotor = ListMotor::find($id);
            if($listMotor){
                $listMotor->update([
                    'tipe_motor' => $request->tipe_motor,
                    'merk_motor' => $request->merk_motor,
                    'nama_motor' => $request->nama_motor,
                    'stok_motor' => $request->stok_motor,
                    'status_motor' => $request->status_motor,
                    'harga_motor_per_1_hari' => $request->harga_motor_per_1_hari,
                    'harga_motor_per_1_minggu' => $request->harga_motor_per_1_minggu,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Data motor berhasil diupdate',
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Data motor tidak ditemukan',
                ], 404);
            }
        }
    }
}

