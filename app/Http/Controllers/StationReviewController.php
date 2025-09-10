<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StationReviewController extends Controller
{

    public function index(Station $station): JsonResponse
    {
        $reviews = $station->reviews()
            ->with('user:id,name')
            ->latest()
            ->get();

        $data = $reviews->map(function ($r) {
            return [
                'id'         => $r->id,
                'station_id' => $r->station_id,
                'user'       => [
                    'id'   => $r->user_id,
                    'name' => optional($r->user)->name,
                ],
                'rating'     => (int) $r->rating,
                'comment'    => (string) $r->comment,
                'created_at' => optional($r->created_at)?->toIso8601String(),
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function store(Request $request, Station $station)
    {
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5',
        ]);

        $review = Review::create([
            'station_id' => $station->id,
            'user_id'    => $request->user()->id,
            'rating'     => $validated['rating'],
            'comment'    => $validated['comment'],
        ]);

        return response()->json([
            'message' => 'Review created successfully',
            'data'    => $review,
        ], 201);
    }
}
