<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validated = $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i',
            'message' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'car_id' => $car->id,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Test drive booking submitted successfully.',
            'booking' => $booking,
        ], 201);
    }
}