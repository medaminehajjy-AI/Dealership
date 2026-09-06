<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;


class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with([
            'user',
            'car.brand',
        ])
        ->latest()
        ->get();

        return response()->json([
            'bookings' => $bookings
        ]);
    }
     
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking = Booking::findOrFail($id);

        $booking->status = $request->status;
        $booking->save();

        return response()->json([
            'message' => 'Booking status updated successfully.',
            'booking' => $booking->load([
                'user',
                'car.brand',
            ]),
        ]);
    }



    



}