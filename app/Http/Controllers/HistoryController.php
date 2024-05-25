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
        $history = History::with(['listMotor', 'diskon'])->get();

        if($history->count() > 0) {
            return response()->json([
                'status' => 200,
                'history' => $history,
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
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|unique:histories,email|max:255',
            'no_telp' => 'required|string|max:20',
            'akun_sosmed' => 'required|string|max:255',
            'alamat' => 'required|string',
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
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'akun_sosmed' => $request->akun_sosmed,
                'alamat' => $request->alamat,
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
                    'history' => [
                        "id" => $history->id,
                        "nama_lengkap" => $history->nama_lengkap,
                        "email" => $history->email,
                        "no_telp" => $history->no_telp,
                        "akun_sosmed" => $history->akun_sosmed,
                        "alamat" => $history->alamat,
                        "penyewa" => $history->penyewa,
                        "motor_id" => $history->motor_id,
                        "tanggal_booking" => $history->tanggal_booking,
                        "keperluan_menyewa" => $history->keperluan_menyewa,
                        "penerimaan_motor" => $history->penerimaan_motor,
                        "nama_kontak_darurat" => $history->nama_kontak_darurat,
                        "nomor_kontak_darurat" => $history->nomor_kontak_darurat,
                        "hubungan_dengan_kontak_darurat" => $history->hubungan_dengan_kontak_darurat,
                        "diskon_id" => $history->diskon_id,
                        "metode_pembayaran" => $history->metode_pembayaran,
                        "total_pembayaran" => $history->total_pembayaran,
                        "status_history" => $history->status_history,
                        "updated_at" => $history->updated_at,
                        "created_at" => $history->created_at,
                    ],
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
        $history = History::with(['listMotor', 'diskon'])->find($id);

        if($history) {
            return response()->json([
                'status' => 200,
                'history' => $history,
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
            'nama_lengkap' => 'string',
            'email' => 'string',
            'no_telp' => 'string',
            'akun_sosmed' => 'string',
            'alamat' => 'string',
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
                    'nama_lengkap',
                    'email',
                    'no_telp',
                    'akun_sosmed',
                    'alamat',
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
                    'history' => $history,
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
                'history' => $history,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data history user tidak ditemukan',
            ], 404);
        }
    }
}
