<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // get all reviews
    public function index()
    {
        $reviews = Review::all();
        return response()->json($reviews, 200);
    }

    //get Review
    public function getReview($id){
        $review = Review::findOrFail($id);
        return response()->json($review);
    }

    //create review
    public function store(Request $request){
        $validated = $request->validate([
            'station_id'=> 'integer',
            'user_id'=> 'integer',
            'rating'=> 'integer',
            'comment'=> 'required|string',
        ]);

        $review = Review::create($validated);

        return response()->json(
            [
                'message' => 'Review created successfully',
                'data' => $review
            ], 500);
    }

    //update review
    public function updateReview($id, Request $request){

        $review = Review::findOrFail($id);

        $validated = $request->validate([
            'station_id'=> 'integer',
            'user_id'=> 'integer',
            'rating'=> 'integer',
            'comment'=> 'required|string',
        ]);

        $review->update($validated);

        return response()->json(
            [
                'message' => 'Review updated successfully',
                'data' => $review
            ], 500);
    }

    //delete review
    public function deleteReview($id){
        {
            $review = Review::findOrFail($id);
            $review->delete();
        }

        return response()->json(
            [
                'message' => 'Review deleted successfully'
            ], 500);
    }
}