<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ReviewController extends Controller
{
    public function index()
    {
        $review = UserReview::all();
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
            'pengguna_id' => 'required',
            'rating' => 'required|numeric|max:5',
            'komentar' => 'required|string|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{

            $review = UserReview::create([
                'pengguna_id' => $request->pengguna_id,
                'rating' => $request->rating,
                'komentar' => $request->komentar,
            ]);

            if($review){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data reviewer berhasil ditambahkan',
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
        $review = UserReview::find($id);
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
            'rating' => 'numeric|max:5',
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
                $review->fill($request->only([
                    'rating',
                    'komentar',
                ]));
            
                $review->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data reviewer berhasil diubah',
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
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data reviewer tidak ditemukan',
            ], 404);
        }
    }
}
