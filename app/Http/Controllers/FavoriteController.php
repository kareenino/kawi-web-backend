<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // get all favorites
    public function index(){
        $favorites = Favorite::all();
        return response()->json($favorites, 200);
    }

    //get Favorite
    public function getFavorite($id){
        $favorite = Favorite::findOrFail($id);
        return response()->json($favorite);
    }

    //create favorite
    public function store(Request $request){
        $validated = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'station_id' => 'required|exists:stations,id',
        ]);

        $favorite = Favorite::create($validated);

        return response()->json(
            [
                'message' => 'Favorite created successfully',
                'data' => $favorite
            ], 500);
    }

    //update favorite
    public function updateFavorite($id, Request $request){

        $favorite = Favorite::findOrFail($id);
        $validated = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'station_id' => 'required|exists:stations,id',
        ]);

        $favorite->update($validated);
        return response()->json(
            [
                'message' => 'Favorite updated successfully',
                'data' => $favorite
            ], 500);
    }

    //delete favorite
    public function deleteFavorite($id){
        {
            $favorite = Favorite::findOrFail($id);
            $favorite->delete();
        }

        return response()->json(
            [
                'message' => 'Favorite deleted successfully'
            ], 500);
    }
}