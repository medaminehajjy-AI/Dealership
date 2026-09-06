<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    public function store(Request $request, $carId)
    {
        $car = Car::find($carId);

        if (!$car) {
            return response()->json([
                'message' => 'Car not found'
            ], 404);
        }

        if ($car->status !== 'available') {
            return response()->json([
                'message' => 'This car is not available'
            ], 400);
        }

        $validated = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        $purchaseRequest = PurchaseRequest::create([
            'user_id' => $request->user()->id,
            'car_id' => $car->id,
            'status' => 'pending',
            'message' => $validated['message'] ?? null,
        ]);

        return response()->json([
            'message' => 'Purchase request submitted successfully',
            'purchase_request' => $purchaseRequest,
        ], 201);
    }

    public function index(Request $request)
    {
        $purchaseRequests = PurchaseRequest::with([
            'car.brand',
            'car.category',
            'car.images',
        ])
        ->where('user_id', $request->user()->id)
        ->latest()
        ->get();

        return response()->json([
            'purchase_requests' => $purchaseRequests
        ]);
    }
}
