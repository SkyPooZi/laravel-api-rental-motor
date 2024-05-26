<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index()
    {
        $notification = Notification::with(['user'])->get();

        if($notification->count() > 0 ){
            return response()->json([
                'status' => 200,
                'notification' => $notification,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data notification user tidak ditemukan',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengguna_id' => 'required',
            'pesan' => 'required|string|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $notification = Notification::create([
                'pengguna_id' => $request->pengguna_id,
                'pesan' => $request->pesan,
            ]);

            if($notification){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data notification user berhasil ditambahkan',
                    'notification' => [
                        "id" => $notification->id,
                        "pengguna_id" => $notification->pengguna_id,
                        "pesan" => $notification->pesan,
                        "updated_at" => $notification->updated_at,
                        "created_at"=> $notification->created_at,
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Data notification user gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $notification = Notification::with(['user'])->find($id);
        
        if($notification){
            return response()->json([
                'status' => 200,
                'notification' => $notification,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data notification user tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pesan' => 'string|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $notification = Notification::find($id);
            if($notification){ 
                $notification->fill($request->only([
                    'pesan',
                ]));
            
                $notification->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data notification user berhasil diubah',
                    'notification' => $notification,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Data notification user gagal diubah',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);
        if($notification){
            $notification->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data notification user berhasil dihapus',
                'notification' => $notification,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data notification user tidak ditemukan',
            ], 404);
        }
    }
}
