<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SwapHistory;

class SwapHistoryController extends Controller
{
    /**
     * Show all swap history (for admin or testing).
     */
    public function index()
    {
        $histories = SwapHistory::all();
        return response()->json($histories);
    }

    /**
     * Show swap history for a specific user.
     */
    public function userHistory($userId)
    {
        $histories = SwapHistory::where('user_id', $userId)->orderBy('swapped_at', 'desc')->get();
        return response()->json($histories);
    }

    /**
     * Store a new swap history record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'station_id' => 'required|integer',
            'battery_count' => 'required|integer|min:1',
            'swapped_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $history = SwapHistory::create($validated);

        return response()->json([
            'message' => 'Swap history recorded successfully',
            'data' => $history
        ], 201);
    }
}