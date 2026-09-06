<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request, $carId)
    {
        $car = Car::find($carId);

        if (!$car) {
            return response()->json([
                'message' => 'Car not found'
            ], 404);
        }

        $favorite = Favorite::firstOrCreate([
            'user_id' => $request->user()->id,
            'car_id' => $car->id,
        ]);

        return response()->json([
            'message' => 'Car added to favorites',
            'favorite' => $favorite
        ], 201);
    }

    public function destroy(Request $request, $carId)
    {
        $favorite = Favorite::where('user_id', $request->user()->id)
            ->where('car_id', $carId)
            ->first();

        if (!$favorite) {
            return response()->json([
                'message' => 'Favorite not found'
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'message' => 'Car removed from favorites'
        ]);
    }

    public function check(Request $request, $carId)
    {
        $favorite = Favorite::where('user_id', $request->user()->id)
            ->where('car_id', $carId)
            ->exists();

        return response()->json([
            'is_favorite' => $favorite
        ]);
    }

    // this method returns all favorite cars for the authenticated user
    public function index(Request $request)
    {
        $favorites = Favorite::with([
            'car.brand',
            'car.category',
            'car.images',
        ])
        ->where('user_id', $request->user()->id)
        ->get();

        return response()->json([
            'favorites' => $favorites
        ]);
    }
}
