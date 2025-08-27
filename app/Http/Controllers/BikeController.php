<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    // get all bikes
    public function index()
    {
        $bikes = Bike::all();
        return response()->json($bikes, 200);
    }

    //get Bike
    public function getBike($id){
        $bike = Bike::findOrFail($id);
        return response()->json($bike);
    }

    //create bike
    public function store(Request $request){
        $validated = $request->validate([
        'user_id'          => 'required|integer|exists:users,id',
        'plate_number'     => 'required|string|max:50|unique:bikes,plate_number',
        'model'            => 'nullable|string|max:120',
        'year'             => 'nullable|integer',
        'insurance_expiry' => 'nullable|date',
        'last_serviced_at' => 'nullable|date',
        'odometer_km'      => 'nullable|integer|min:0',
        'photo_url'        => 'nullable|string|max:255',
    ]);


    $bike = Bike::create($validated);

    return response()->json(
        [
            'message' => 'Bike created successfully',
            'data' => $bike
        ], 500);
    }

    //update bike
    public function updateBike($id, Request $request){

        $bike = Bike::findOrFail($id);

        $validated = $request->validate([
            'user_id'          => 'required|integer|exists:users,id',
            'plate_number'     => 'required|string|max:50|unique:bikes,plate_number',
            'model'            => 'nullable|string|max:120',
            'year'             => 'nullable|integer',
            'insurance_expiry' => 'nullable|date',
            'last_serviced_at' => 'nullable|date',
            'odometer_km'      => 'nullable|integer|min:0',
            'photo_url'        => 'nullable|string|max:255',
        ]);

        $bike->update($validated);

        return response()->json(
            [
                'message' => 'Bike updated successfully',
                'data' => $bike
            ], 500);
    }

    //delete bike
    public function deleteBike($id){
        {
            $bike = Bike::findOrFail($id);
            $bike->delete();
        }

        return response()->json(
            [
                'message' => 'Bike deleted successfully'
            ], 500);
    }
}