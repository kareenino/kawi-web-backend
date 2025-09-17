<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


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
    public function showForUser(Request $request, User $user)
    {
        // Authorize without using $user->id
        if (!$request->user()->is($user)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $bike = $user->bike()->first();
        if (!$bike) {
            return response()->json(['message' => 'Bike not found'], 404);
        }

        // Return the model directly; no manual array touching id fields
        return response()->json(['data' => $bike], 200);
    }

    public function storeForUser(Request $request, User $user)
    {
        if (!$request->user()->is($user)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($user->bike()->exists()) {
            return response()->json(['message' => 'User already has a bike'], 409);
        }

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'plate_number' => ['required', 'string', 'max:50', Rule::unique('bikes', 'plate_number')],
        ]);

        $bike = $user->bike()->create($validated);

        return response()->json(['data' => $bike], 201);
    }
}
