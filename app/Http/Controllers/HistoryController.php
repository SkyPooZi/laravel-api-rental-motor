<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
{
    public function index()
    {
        $history = History::all();

        if($history->count() > 0) {
            return response()->json([
                'status' => 200,
                'History' => $history,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data history user tidak ditemukan',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'required',
            'akun_sosmed' => 'required|string',
            'penyewa' => 'required|string',
            'motor_id' => 'required',
            'tanggal_booking' => 'required|string',
            'keperluan_menyewa' => 'required|string|max:255',
            'penerimaan_motor' => 'required|string',
            'nama_kontak_darurat' => 'required|string',
            'nomor_kontak_darurat' => 'required|string',
            'hubungan_dengan_kontak_darurat' => 'required|string',
            'diskon_id' => 'required',
            'metode_pembayaran' => 'required|string',
            'total_pembayaran' => 'required|int',
            'status_history' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $history = History::create([
                'pengguna_id' => $request->pengguna_id,
                'akun_sosmed' => $request->akun_sosmed,
                'penyewa' => $request->penyewa,
                'motor_id' => $request->motor_id,
                'tanggal_booking' => $request->tanggal_booking,
                'keperluan_menyewa' => $request->keperluan_menyewa,
                'penerimaan_motor' => $request->penerimaan_motor,
                'nama_kontak_darurat' => $request->nama_kontak_darurat,
                'nomor_kontak_darurat' => $request->nomor_kontak_darurat,
                'hubungan_dengan_kontak_darurat' => $request->hubungan_dengan_kontak_darurat,
                'diskon_id' => $request->diskon_id,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_pembayaran' => $request->total_pembayaran,
                'status_history' => $request->status_history,
            ]);
    
            if($history) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Data history user berhasil ditambahkan',
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Data history user gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $history = History::find($id);

        if($history) {
            return response()->json([
                'status' => 200,
                'History' => $history,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data history user tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => '',
            'akun_sosmed' => 'string',
            'penyewa' => 'string',
            'motor_id' => '',
            'tanggal_booking' => 'string',
            'keperluan_menyewa' => 'string|max:255',
            'penerimaan_motor' => 'string',
            'nama_kontak_darurat' => 'string',
            'nomor_kontak_darurat' => 'string',
            'hubungan_dengan_kontak_darurat' => 'string',
            'diskon_id' => '',
            'metode_pembayaran' => 'string',
            'total_pembayaran' => 'int',
            'status_history' => 'string',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $history = History::find($id);

            if($history) {
                $history->fill($request->only([
                    'pengguna_id',
                    'akun_sosmed',
                    'penyewa',
                    'motor_id',
                    'tanggal_booking',
                    'keperluan_menyewa',
                    'penerimaan_motor',
                    'nama_kontak_darurat',
                    'nomor_kontak_darurat',
                    'hubungan_dengan_kontak_darurat',
                    'diskon_id',
                    'metode_pembayaran',
                    'total_pembayaran',
                    'status_history',
                ]));
            
                $history->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data history user berhasil diupdate',
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data history user tidak ditemukan',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $history = History::find($id);

        if($history) {
            $history->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Data history user berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data history user tidak ditemukan',
            ], 404);
        }
    }
}
