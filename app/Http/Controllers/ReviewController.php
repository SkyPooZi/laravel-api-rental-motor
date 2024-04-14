<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserReview;

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
}
