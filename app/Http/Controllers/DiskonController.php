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
            'kode_diskon' => 'required|string|max:191',
            'nama_diskon' => 'required|string|max:191|',
            'persentase_diskon' => 'required|int|max:20',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $diskon = Diskon::create([
                'kode_diskon' => $request->kode_diskon,
                'nama_diskon' => $request->nama_diskon,
                'persentase_diskon' => $request->persentase_diskon,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_berakhir' => $request->tanggal_berakhir,
            ]);

            if($diskon){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data diskon berhasil ditambahkan',
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

    public function edit($id)
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
            'kode_diskon' => 'required|string|max:191',
            'nama_diskon' => 'required|string|max:191|',
            'persentase_diskon' => 'required|int|max:20',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $diskon = Diskon::find($id);
            if($diskon){
                $diskon->update([
                    'kode_diskon' => $request->kode_diskon,
                    'nama_diskon' => $request->nama_diskon,
                    'persentase_diskon' => $request->persentase_diskon,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_berakhir' => $request->tanggal_berakhir,
                ]); 
            }
            

            if($diskon){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data diskon berhasil diubah',
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
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data diskon tidak ditemukan',
            ], 404);
        }
    }
}
