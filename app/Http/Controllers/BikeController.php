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
    // New: delegate “me” routes to existing logic
    public function showForUserSelf(Request $request)
    {
        $auth = $request->user();
        if (!$auth) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        // Re-use showForUser by binding the $auth user
        return $this->showForUser($request, $auth);
    }

    public function storeForUserSelf(Request $request)
    {
        $auth = $request->user();
        if (!$auth) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        return $this->storeForUser($request, $auth);
    }

    // Existing: GET /users/{user}/bike
    public function showForUser(Request $request, User $user)
    {
        $auth = $request->user();
        if (!$auth) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        if (!$auth->is($user)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $bike = $user->bike()->first();
        if (!$bike) {
            return response()->json(['message' => 'Bike not found'], 404);
        }

        // ✅ Return keys that match your Flutter model
        return response()->json([
            'data' => [
                'name'               => $bike->name,
                'plate_number'       => $bike->plate_number,
                'insurance_expiry'   => optional($bike->insurance_expiry)->toISOString(), // Carbon|null
                'last_serviced_at'   => optional($bike->last_serviced_at)->toISOString(), // Carbon|null
            ],
        ], 200);
    }

    // Existing: POST /users/{user}/bike
    public function storeForUser(Request $request, User $user)
    {
        $auth = $request->user();
        if (!$auth) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        if (!$auth->is($user)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($user->bike()->exists()) {
            return response()->json(['message' => 'User already has a bike'], 409);
        }

        // ✅ accept optional dates
        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:255'],
            'plate_number'       => ['required', 'string', 'max:50', Rule::unique('bikes', 'plate_number')],
            'insurance_expiry'   => ['nullable', 'date'],
            'last_serviced_at'   => ['nullable', 'date'],
        ]);

        $bike = $user->bike()->create($validated);

        return response()->json([
            'data' => [
                'name'               => $bike->name,
                'plate_number'       => $bike->plate_number,
                'insurance_expiry'   => optional($bike->insurance_expiry)->toISOString(),
                'last_serviced_at'   => optional($bike->last_serviced_at)->toISOString(),
            ],
        ], 201);
    }
}