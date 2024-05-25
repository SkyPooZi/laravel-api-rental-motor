<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Diskon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|string',
            'nama_diskon' => 'required|string|max:191',
            'potongan_harga' => 'required|int|max:20',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $diskon = Diskon::create([
                'gambar' => $request->gambar,
                'nama_diskon' => $request->nama_diskon,
                'potongan_harga' => $request->potongan_harga,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
            ]);

            if($diskon){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data diskon berhasil ditambahkan',
                    'diskon' => [
                        "id" => $diskon->id,
                        "gambar" => $diskon->gambar,
                        "nama_diskon" => $diskon->nama_diskon,
                        "potongan_harga" => $diskon->potongan_harga,
                        "tanggal_mulai" => $diskon->tanggal_mulai,
                        "tanggal_selesai" => $diskon->tanggal_selesai,
                        "kode_diskon" => $diskon->kode_diskon,
                        "updated_at" => $diskon->updated_at,
                        "created_at" => $diskon->created_at,
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Data diskon gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $diskon = Diskon::find($id);
        if($diskon){
            return response()->json([
                'status' => 200,
                'diskon' => $diskon,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data diskon tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'string',
            'nama_diskon' => 'string|max:191',
            'potongan_harga' => 'int|max:20',
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $diskon = Diskon::find($id);
            if($diskon){
                $diskon->fill($request->only([
                    'gambar',
                    'nama_diskon',
                    'potongan_harga',
                    'tanggal_mulai',
                    'tanggal_selesai',
                ]));
            
                $diskon->save();
                
                return response()->json([
                    'status' => 200,
                    'message' => 'Data diskon berhasil diubah',
                    'diskon' => $diskon,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Data diskon tidak ada atau tidak ditemukan',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $diskon = Diskon::find($id);
        if($diskon){
            $diskon->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data diskon berhasil dihapus',
                'diskon' => $diskon,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data diskon tidak ditemukan',
            ], 404);
        }
    }
}
