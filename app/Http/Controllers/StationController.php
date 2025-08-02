<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    // get all stations
    public function index(){
        $stations = Station::all();
        return response()->json($stations, 200);
    }

    //get Station
    public function getStation($id){
        $station = Station::findOrFail($id);
        return response()->json($station);
    }

    //create station
    public function store(Request $request){
        $validated = $request->validate([
            'name'=> 'required|string',
            'operator_id'=> 'required|integer',
            'address'=> 'required|string',
            'capacity'=> 'required|integer',
            'available_batteries'=> 'required|integer',
            'status'=> 'required|string',
        ]);

        $station = Station::create($validated);

        return response()->json(
            [
                'message' => 'Station created successfully',
                'data' => $station
            ], 500);
    }

    //update station
    public function updateStation($id, Request $request){

        $station = Station::findOrFail($id);

        $validated = $request->validate([
            'name'=> 'required|string',
            'operator_id'=> 'required|integer',
            'address'=> 'required|string',
            'capacity'=> 'required|integer',
            'available_batteries'=> 'required|integer',
            'status'=> 'required|string',
        ]);

        $station->update($validated);

        return response()->json(
            [
                'message' => 'Station updated successfully',
                'data' => $station
            ], 500);
    }

    //delete station
    public function deleteStation($id){
        {
            $station = Station::findOrFail($id);
            $station->delete();
        }

        return response()->json(
            [
                'message' => 'Station deleted successfully'
            ], 500);
    }
}