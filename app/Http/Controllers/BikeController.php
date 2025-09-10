<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\User;
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
    public function getBike(int $id)
    {
        $bike = Bike::findOrFail($id);
        return response()->json($bike);
    }

    //create bike
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'          => 'nullable|integer|exists:users,id',
            'plate_number'     => 'required|string|max:50|unique:bikes,plate_number',
            'name'             => 'nullable|string|max:120',
            'insurance_expiry' => 'nullable|date',
            'last_serviced_at' => 'nullable|date',
        ]);


        $bike = Bike::create($validated);

        return response()->json(
            [
                'message' => 'Bike created successfully',
                'data' => $bike
            ],
            500
        );
    }

    //update bike
    public function updateBike($id, Request $request)
    {

        $bike = Bike::findOrFail($id);

        $validated = $request->validate([
            'user_id'          => 'nullable|integer|exists:users,id',
            'plate_number'     => 'string|max:50|unique:bikes,plate_number',
            'name'             => 'nullable|string|max:120',
            'insurance_expiry' => 'nullable|date',
            'last_serviced_at' => 'nullable|date',
        ]);

        $bike->update($validated);

        return response()->json(
            [
                'message' => 'Bike updated successfully',
                'data' => $bike
            ],
            500
        );
    }

    //delete bike
    public function deleteBike($id)
    { {
            $bike = Bike::findOrFail($id);
            $bike->delete();
        }

        return response()->json(
            [
                'message' => 'Bike deleted successfully'
            ],
            500
        );
    }

    // GET /api/bike/{userId}
    // public function showByUserId(int $userId)
    // {
    //     $bike = Bike::where('user_id', $userId)->first();

    //     if (!$bike) {
    //         // choose the shape you prefer: 404 or empty object
    //         return response()->json(['message' => 'Bike not found'], 404);
    //     }

    //     return response()->json([
    //         'id'               => $bike->id,
    //         'user_id'          => $bike->user_id,
    //         'name'             => $bike->name,
    //         'plate_number'     => $bike->plate_number,
    //         'insurance_expiry' => optional($bike->insurance_expiry)->toISOString(),
    //         'last_serviced_at' => optional($bike->last_serviced_at)->toISOString(),
    //     ]);
    // }

    // (Recommended RESTful alternative) GET /api/users/{user}/bike
    public function showForUser(User $user)
    {
        $bike = $user->bike;

        if (!$bike) {
            return response()->json(['message' => 'Bike not found'], 404);
        }

        return response()->json([
            'id'               => $bike->id,
            'user_id'          => $bike->user_id,
            'name'             => $bike->name,
            'plate_number'     => $bike->plate_number,
            'insurance_expiry' => optional($bike->insurance_expiry)->toISOString(),
            'last_serviced_at' => optional($bike->last_serviced_at)->toISOString(),
        ]);
    }
}
