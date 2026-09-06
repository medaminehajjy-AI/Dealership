<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;

class AdminPurchaseRequestController extends Controller
{
    public function index()
    {
        $purchaseRequests = PurchaseRequest::with([
            'user',
            'car.brand',
            'car.category',
            'car.images',
        ])
        ->latest()
        ->get();

        return response()->json([
            'purchase_requests' => $purchaseRequests
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,completed',
        ]);

        $purchaseRequest = PurchaseRequest::with('car')->find($id);

        if (!$purchaseRequest) {
            return response()->json([
                'message' => 'Purchase request not found'
            ], 404);
        }

        // A completed request represents a completed sale.
        if ($validated['status'] === 'completed') {

            if (!$purchaseRequest->car) {
                return response()->json([
                    'message' => 'The car associated with this purchase request was not found'
                ], 404);
            }

            if ($purchaseRequest->car->status !== 'available') {
                return response()->json([
                    'message' => 'This car is no longer available'
                ], 400);
            }

            $purchaseRequest->update([
                'status' => 'completed',
            ]);

            $purchaseRequest->car->update([
                'status' => 'sold',
            ]);
        } else {
            $purchaseRequest->update([
                'status' => $validated['status'],
            ]);
        }

        return response()->json([
            'message' => 'Purchase request status updated successfully',
            'purchase_request' => $purchaseRequest->fresh(['car']),
        ]);
    }
}
