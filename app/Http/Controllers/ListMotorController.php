<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ListMotor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ListMotorController extends Controller
{
    public function index()
    {
        $listMotor = ListMotor::all();

        if($listMotor->count() > 0 ){
            return response()->json([
                'status' => 200,
                'listMotor' => $listMotor,
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
            'gambar_motor' => 'required|file|image|max:2048',
            'nama_motor' => 'required|string|max:191',
            'tipe_motor' => 'required|string|max:191',
            'merk_motor' => 'required|string|max:191',
            'stok_motor' => 'required|int',
            'harga_motor_per_1_hari' => 'required|int',
            'harga_motor_per_1_minggu' => 'required|int',
            'harga_motor_diantar' => 'required|int',
            'status_motor' => 'required|string|max:191',
            'tanggal_mulai_tidak_tersedia' => 'nullable|date_format:Y-m-d H:i:s',
            'tanggal_selesai_tidak_tersedia' => 'nullable|date_format:Y-m-d H:i:s',
            'is_hidden' => 'required|boolean',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $gambar_motor = null;
            if ($request->hasFile('gambar_motor')) {
                $gambar_motor = $request->file('gambar_motor')->store('images', 'public');
            }
                
            $listMotor = ListMotor::create([
                'gambar_motor' => $gambar_motor,
                'nama_motor' => $request->nama_motor,
                'tipe_motor' => $request->tipe_motor,
                'merk_motor' => $request->merk_motor,
                'stok_motor' => $request->stok_motor,
                'harga_motor_per_1_hari' => $request->harga_motor_per_1_hari,
                'harga_motor_per_1_minggu' => $request->harga_motor_per_1_minggu,
                'harga_motor_diantar' => $request->harga_motor_diantar,
                'status_motor' => $request->status_motor,
                'tanggal_mulai_tidak_tersedia' => $request->tanggal_mulai_tidak_tersedia,
                'tanggal_selesai_tidak_tersedia' => $request->tanggal_selesai_tidak_tersedia,
                'is_hidden' => $request->is_hidden,
            ]);
    
            if($listMotor){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data motor berhasil ditambahkan',
                    'listMotor' => [
                        "id" => $listMotor->id,
                        "gambar_motor" => $listMotor->gambar_motor,
                        "nama_motor" => $listMotor->nama_motor,
                        "tipe_motor" => $listMotor->tipe_motor,
                        "merk_motor" => $listMotor->merk_motor,
                        "stok_motor" => $listMotor->stok_motor,
                        "harga_motor_per_1_hari" => $listMotor->harga_motor_per_1_hari,
                        "harga_motor_per_1_minggu" => $listMotor->harga_motor_per_1_minggu,
                        'harga_motor_diantar' => $listMotor->harga_motor_diantar,
                        "status_motor" => $listMotor->status_motor,
                        "tanggal_mulai_tidak_tersedia" => $listMotor->tanggal_mulai_tidak_tersedia,
                        "tanggal_selesai_tidak_tersedia" => $listMotor->tanggal_selesai_tidak_tersedia,
                        "is_hidden" => $listMotor->is_hidden,
                        "updated_at" => $listMotor->updated_at,
                        "created_at" => $listMotor->created_at,
                    ],
                ], 200);
            } else {
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
                'listMotor' => $listMotor,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data motor tidak ditemukan',
            ], 404);
        }
    }

    public function updateMotorStatus()
    {
        $this->updateAvailableStatus();
    }

    public function updateAvailableStatus()
    {
        \Log::info('Schedule Update Status Tersedia ' . now());
        $listMotor = ListMotor::where('tanggal_selesai_tidak_tersedia', '<', now())
            ->where('status_motor', '!=', 'Tersedia')
            ->get();

        foreach ($listMotor as $motor) {
            $motor->status_motor = 'Tersedia';
            $motor->tanggal_mulai_tidak_tersedia = null;
            $motor->tanggal_selesai_tidak_tersedia = null;
            $motor->save();
            \Log::info('Schedule Update Status Tersedia: ' . $motor);
        }
        \Log::info('Schedule Update Status Tersedia Stop: ' . now());
    }

    public function updateDate(int $id)
    {
        $listMotor = ListMotor::find($id);
        if($listMotor){
            $listMotor->tanggal_mulai_tidak_tersedia = null;
            $listMotor->tanggal_selesai_tidak_tersedia = null;
            $listMotor->save();

            return response()->json([
                'status' => 200,
                'message' => 'Data motor berhasil diupdate',
                'listMotor' => $listMotor,
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
            'pengguna_id' => 'required',
            'gambar_motor' => 'file|image|max:2048',
            'nama_motor' => 'string|max:191',
            'tipe_motor' => 'string|max:191',
            'merk_motor' => 'string|max:191',
            'stok_motor' => 'int',
            'harga_motor_per_1_hari' => 'int',
            'harga_motor_per_1_minggu' => 'int',
            'harga_motor_diantar' => 'int',
            'status_motor' => 'required|string|max:191',
            'tanggal_mulai_tidak_tersedia' => 'date_format:Y-m-d H:i:s',
            'tanggal_selesai_tidak_tersedia' => 'date_format:Y-m-d H:i:s',
            'is_hidden' => 'boolean',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $listMotor = ListMotor::find($id);
            if($listMotor){
                $dataSebelum = $listMotor->toArray();

                if ($request->hasFile('gambar_motor')) {
                    if ($listMotor->gambar_motor) {
                        Storage::disk('public')->delete($listMotor->gambar_motor);
                    }
                    $listMotor->gambar_motor = $request->file('gambar_motor')->store('images', 'public');
                }

                $listMotor->fill($request->only([
                    'nama_motor',
                    'tipe_motor',
                    'merk_motor',
                    'stok_motor',
                    'harga_motor_per_1_hari',
                    'harga_motor_per_1_minggu',
                    'harga_motor_diantar',
                    'status_motor',
                    'tanggal_mulai_tidak_tersedia',
                    'tanggal_selesai_tidak_tersedia',
                    'is_hidden',
                ]));
            
                $listMotor->save();

                $dataSesudah = $listMotor->toArray();

                RiwayatData::create([
                    'pengguna_id' => $request->pengguna_id,
                    'data_sebelum' => $dataSebelum,
                    'data_sesudah' => $dataSesudah,
                    'datetime' => now(),
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Data motor berhasil diupdate',
                    'listMotor' => $listMotor,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Data motor tidak ditemukan',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $listMotor = ListMotor::find($id);

        if($listMotor){
            $listMotor->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data motor berhasil dihapus',
                'listMotor' => $listMotor,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data motor tidak ditemukan',
            ], 404);
        }
    }
}

