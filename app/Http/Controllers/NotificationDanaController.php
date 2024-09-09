<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NotificationDana;
use Illuminate\Support\Facades\Validator;

class NotificationDanaController extends Controller
{
    public function index()
    {
        $notificationDana = NotificationDana::with(['user', 'riwayatData.user', 'riwayatData.listMotor', 'riwayatData.history'])->get();

        if($notificationDana->count() > 0 ){
            return response()->json([
                'status' => 200,
                'notificationDana' => $notificationDana,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data notificationDana user tidak ditemukan',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'required',
            'riwayat_id' => 'required',
            'pesan' => 'required|string',
            'is_hidden' => 'required|boolean',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $notificationDana = NotificationDana::create([
                'pengguna_id' => $request->pengguna_id,
                'riwayat_id' => $request->riwayat_id,
                'pesan' => $request->pesan,
                'datetime' => now(),
                'is_hidden' => $request->is_hidden,
            ]);

            if($notificationDana){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data notificationDana user berhasil ditambahkan',
                    'notificationDana' => [
                        "id" => $notificationDana->id,
                        "pengguna_id" => $notificationDana->pengguna_id,
                        "riwayat_id" => $notificationDana->riwayat_id,
                        "pesan" => $notificationDana->pesan,
                        "datetime" => $notificationDana->datetime,
                        "is_hidden" => $notificationDana->is_hidden,
                        "updated_at" => $notificationDana->updated_at,
                        "created_at"=> $notificationDana->created_at,
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Data notificationDana user gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $notificationDana = NotificationDana::with(['user', 'riwayatData.user', 'riwayatData.listMotor', 'riwayatData.history'])->find($id);
        
        if($notificationDana){
            return response()->json([
                'status' => 200,
                'notificationDana' => $notificationDana,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data notificationDana user tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'nullable',
            'riwayat_id' => 'nullable',
            'pesan' => 'string',
            'is_hidden' => 'boolean',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $notificationDana = NotificationDana::find($id);
            if($notificationDana){ 
                $notificationDana->fill($request->only([
                    'pengguna_id',
                    'riwayat_id',
                    'pesan',
                    'is_hidden',
                ]));
            
                $notificationDana->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data notificationDana user berhasil diubah',
                    'notificationDana' => $notificationDana,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Data notificationDana user gagal diubah',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $notificationDana = NotificationDana::find($id);
        if($notificationDana){
            $notificationDana->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data notificationDana user berhasil dihapus',
                'notificationDana' => $notificationDana,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data notificationDana user tidak ditemukan',
            ], 404);
        }
    }
}
