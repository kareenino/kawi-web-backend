<?php

namespace App\Http\Controllers;

use App\Models\SwapHistory;
use Illuminate\Http\Request;

class SwapHistoryController extends Controller
{
    // get all swaphistories
    public function index(){
        $swaphistories = SwapHistory::all();
        return response()->json($swaphistories, 200);
    }

    //get SwapHistory
    public function getSwapHistory($id){
        $swaphistory = SwapHistory::findOrFail($id);
        return response()->json($swaphistory);
    }

    //create swaphistory
    public function store(Request $request){
        $validated = $request->validate([
            'user_id'=> 'required|integer',
            'station_id'=> 'required|integer',
            'battery_count'=> 'required|integer',
            'notes'=> 'required|string',
        ]);

        $swaphistory = SwapHistory::create($validated);

        return response()->json(
            [
                'message' => 'Swap History created successfully',
                'data' => $swaphistory
            ], 500);
    }

    //update swaphistory
    public function updateSwapHistory($id, Request $request){

        $swaphistory = SwapHistory::findOrFail($id);

        $validated = $request->validate([
             'user_id'=> 'required|integer',
            'station_id'=> 'required|integer',
            'battery_count'=> 'required|integer',
            'notes'=> 'required|string',
        ]);

        $swaphistory->update($validated);

        return response()->json(
            [
                'message' => 'Swap History updated successfully',
                'data' => $swaphistory
            ], 500);
    }

    //delete swaphistory
    public function deleteSwapHistory($id){
        {
            $swaphistory = SwapHistory::findOrFail($id);
            $swaphistory->delete();
        }

        return response()->json(
            [
                'message' => 'Swap History deleted successfully'
            ], 500);
    }
}