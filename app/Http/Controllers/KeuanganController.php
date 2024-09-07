<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Support\Facades\Validator;

class KeuanganController extends Controller
{
    public function index()
    {
        $keuangan = Keuangan::with(['user', 'listMotor', 'diskon', 'ulasan'])->get();

        if($keuangan->count() > 0) {
            return response()->json([
                'status' => 200,
                'keuangan' => $keuangan,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data keuangan tidak ditemukan',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'history_id' => 'required',
            'total_harga_motor' => 'required|int',
            'total_biaya_overtime' => 'nullable|int',
            'total_biaya_diantar' => 'nullable|int',
            'total_potongan_point' => 'nullable|int',
            'total_biaya_diskon' => 'required|int',
            'total_biaya_admin' => 'required|int',
            'total_pembayaran' => 'required|int',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $keuangan = Keuangan::create([
                'history_id' => $request->history_id,
                'total_harga_motor' => $request->total_harga_motor,
                'total_biaya_overtime' => $request->total_biaya_overtime ?? 0,
                'total_biaya_diantar' => $request->total_biaya_diantar ?? 0,
                'total_potongan_point' => $request->total_potongan_point ?? 0,
                'total_biaya_diskon' => $request->total_biaya_diskon,
                'total_biaya_admin' => $request->total_biaya_admin,
                'total_pembayaran' => $request->total_pembayaran,
            ]);
    
            if($keuangan) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data keuangan user berhasil ditambahkan',
                    'keuangan' => [
                        "id" => $keuangan->id,
                        "history_id" => $keuangan->history_id,
                        "total_harga_motor" => $keuangan->total_harga_motor,
                        "total_biaya_overtime" => $keuangan->total_biaya_overtime,
                        "total_biaya_diantar" => $keuangan->total_biaya_diantar,
                        "total_potongan_point" => $keuangan->total_potongan_point,
                        "total_biaya_diskon" => $keuangan->total_biaya_diskon,
                        "total_biaya_admin" => $keuangan->total_biaya_admin,
                        "total_pembayaran" => $keuangan->total_pembayaran,
                        "updated_at" => $keuangan->updated_at,
                        "created_at" => $keuangan->created_at,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Data keuangan gagal ditambahkan', 
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $keuangan = Keuangan::with(['user', 'listMotor', 'diskon', 'ulasan'])->find($id);

        if($keuangan) {
            return response()->json([
                'status' => 200,
                'keuangan' => $keuangan,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data keuangan tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'total_harga_motor' => 'int',
            'total_biaya_overtime' => 'int',
            'total_biaya_diantar' => 'int',
            'total_potongan_point' => 'int',
            'total_biaya_diskon' => 'int',
            'total_biaya_admin' => 'int',
            'total_biaya_reschedule' => 'int',
            'total_pembayaran' => 'int',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $keuangan = Keuangan::find($id);

            if($keuangan) {
                $keuangan->fill($request->only([
                    'total_harga_motor',
                    'total_biaya_overtime',
                    'total_biaya_diantar',
                    'total_potongan_point',
                    'total_biaya_diskon',
                    'total_biaya_admin',
                    'total_biaya_reschedule',
                    'total_pembayaran',
                ]));
            
                $keuangan->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data keuangan berhasil diupdate',
                    'keuangan' => $keuangan,
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data keuangan tidak ditemukan',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::find($id);

        if($keuangan) {
            $keuangan->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data keuangan berhasil dihapus',
                'keuangan' => $keuangan,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data keuangan tidak ditemukan',
            ], 404);
        }
    }
}
