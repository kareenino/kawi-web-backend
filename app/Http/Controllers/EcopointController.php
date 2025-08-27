<?php

namespace App\Http\Controllers;

use App\Models\Ecopoint;
use Illuminate\Http\Request;

class EcopointController extends Controller
{
    // get all ecopoints
    public function index(){
        $ecopoints = Ecopoint::all();
        return response()->json($ecopoints, 200);
    }

    //get Ecopoint
    public function getEcopoint($id){
        $ecopoint = Ecopoint::findOrFail($id);
        return response()->json($ecopoint);
    }

    //create ecopoint
    public function store(Request $request){
        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'swap_history_id' => 'nullable|exists:swap_histories,id',
            'points_change'   => 'required|integer',
            'reason'          => 'nullable|string|max:120',
        ]);

        $ecopoint = Ecopoint::create($validated);

        return response()->json(
            [
                'message' => 'Ecopoint created successfully',
                'data' => $ecopoint
            ], 500);
    }

    //update ecopoint
    public function updateEcopoint($id, Request $request){

        $ecopoint = Ecopoint::findOrFail($id);
        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'swap_history_id' => 'nullable|exists:swap_histories,id',
            'points_change'   => 'required|integer',
            'reason'          => 'nullable|string|max:120',
        ]);

        $ecopoint->update($validated);
        return response()->json(
            [
                'message' => 'Ecopoint updated successfully',
                'data' => $ecopoint
            ], 500);
    }

    //delete ecopoint
    public function deleteEcopoint($id){
        {
            $ecopoint = Ecopoint::findOrFail($id);
            $ecopoint->delete();
        }

        return response()->json(
            [
                'message' => 'Ecopoint deleted successfully'
            ], 500);
    }
}