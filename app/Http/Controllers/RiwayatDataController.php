<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RiwayatData;
use Illuminate\Support\Facades\Validator;

class RiwayatDataController extends Controller
{
    public function index()
    {
        $riwayatData = RiwayatData::with(['user', 'listMotor', 'diskon', 'ulasan'])->get();

        if($riwayatData->count() > 0) {
            return response()->json([
                'status' => 200,
                'riwayatData' => $riwayatData,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data riwayatData tidak ditemukan',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'nullable',
            'history_id' => 'nullable',
            'data_sebelum' => 'required|string',
            'data_sesudah' => 'required|string',
            'datetime' => 'required|date_format:Y-m-d H:i:s',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $riwayatData = RiwayatData::create([
                'pengguna_id' => $request->pengguna_id,
                'history_id' => $request->history_id,
                'data_sebelum' => $request->data_sebelum,
                'data_sesudah' => $request->data_sesudah,
                'datetime' => $request->datetime,
            ]);
    
            if($riwayatData) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data riwayatData user berhasil ditambahkan',
                    'riwayatData' => [
                        "id" => $riwayatData->id,
                        "pengguna_id" => $riwayatData->pengguna_id,
                        "history_id" => $riwayatData->history_id,
                        "data_sebelum" => $riwayatData->data_sebelum,
                        "data_sesudah" => $riwayatData->data_sesudah,
                        "datetime" => $riwayatData->datetime,
                        "updated_at" => $riwayatData->updated_at,
                        "created_at" => $riwayatData->created_at,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Data riwayatData gagal ditambahkan', 
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $riwayatData = RiwayatData::with(['user', 'listMotor', 'diskon', 'ulasan'])->find($id);

        if($riwayatData) {
            return response()->json([
                'status' => 200,
                'riwayatData' => $riwayatData,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data riwayatData tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'nullable',
            'history_id' => 'nullable',
            'data_sebelum' => 'string',
            'data_sesudah' => 'string',
            'datetime' => 'date_format:Y-m-d H:i:s',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $riwayatData = RiwayatData::find($id);

            if($riwayatData) {
                $riwayatData->fill($request->only([
                    'pengguna_id',
                    'history_id',
                    'data_sebelum',
                    'data_sesudah',
                    'datetime',
                ]));
            
                $riwayatData->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data riwayatData berhasil diupdate',
                    'riwayatData' => $riwayatData,
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data riwayatData tidak ditemukan',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $riwayatData = RiwayatData::find($id);

        if($riwayatData) {
            $riwayatData->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data riwayatData berhasil dihapus',
                'riwayatData' => $riwayatData,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data riwayatData tidak ditemukan',
            ], 404);
        }
    }
}
