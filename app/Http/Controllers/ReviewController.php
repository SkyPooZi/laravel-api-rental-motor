<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index()
    {
        $review = UserReview::with(['user'])->get();

        if($review->count() > 0 ){
            return response()->json([
                'status' => 200,
                'review' => $review,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data reviewer tidak ditemukan',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'required|file|image|max:2048',
            'pengguna_id' => 'required',
            'penilaian' => 'required|numeric|max:5',
            'komentar' => 'required|string|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $gambar = null;
            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar')->store('images', 'public');
            }

            $review = UserReview::create([
                'gambar' => $gambar,
                'pengguna_id' => $request->pengguna_id,
                'penilaian' => $request->penilaian,
                'komentar' => $request->komentar,
            ]);

            if($review){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data reviewer berhasil ditambahkan',
                    'review' => [
                        "id" => $review->id,
                        "gambar" => $review->gambar,
                        "pengguna_id" => $review->pengguna_id,
                        "penilaian" => $review->penilaian,
                        "komentar" => $review->komentar,
                        "updated_at" => $review->updated_at,
                        "created_at"=> $review->created_at,
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Data review gagal ditambahkan',
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $review = UserReview::with(['user'])->find($id);
        
        if($review){
            return response()->json([
                'status' => 200,
                'review' => $review,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data reviewer tidak ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gambar' => 'file|image|max:2048',
            'penilaian' => 'numeric|max:5',
            'komentar' => 'string|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $review = UserReview::find($id);
            if($review){
                if ($request->hasFile('gambar')) {
                    if ($review->gambar) {
                        Storage::disk('public')->delete($review->gambar);
                    }
                    $review->gambar = $request->file('gambar')->store('images', 'public');
                }

                $review->fill($request->only([
                    'penilaian',
                    'komentar',
                ]));
            
                $review->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data reviewer berhasil diubah',
                    'review' => $review,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Data reviewer gagal diubah',
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $review = UserReview::find($id);
        if($review){
            $review->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Data reviewer berhasil dihapus',
                'review' => $review,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data reviewer tidak ditemukan',
            ], 404);
        }
    }
}
