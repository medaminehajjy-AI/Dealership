<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\PurchaseRequest;
use App\Models\User;
use App\Models\Booking;
use App\Models\ContactMessage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $latestPendingBookings = Booking::with([
            'user',
            'car.brand',
        ])
        ->where('status', 'pending')
        ->latest()
        ->take(5)
        ->get();

        $latestPurchaseRequests = PurchaseRequest::with([
            'user',
            'car.brand',
        ])
        ->latest()
        ->take(5)
        ->get();


        $lowInventory = Car::with('brand')
        ->where('status', 'available')
        ->get()
        ->groupBy(function ($car) {
            return $car->brand_id . '-' . $car->model;
        })
        ->map(function ($cars) {
            $car = $cars->first();

            return [
                'brand' => $car->brand?->name ?? 'Unknown Brand',
                'model' => $car->model,
                'available_count' => $cars->count(),
            ];
        })
        ->filter(function ($car) {
            return $car['available_count'] <= 2;
        })
        ->values()
        ->sortBy('available_count')
        ->values();


        $mostRequestedCars = PurchaseRequest::with([
            'car.brand',
        ])
        ->get()
        ->groupBy('car_id')
        ->map(function ($requests) {
            $car = $requests->first()->car;

            if (!$car) {
                return null;
            }

            return [
                'car_id' => $car->id,
                'brand' => $car->brand?->name ?? 'Unknown Brand',
                'model' => $car->model,
                'requests_count' => $requests->count(),
            ];
        })
        ->filter()
        ->sortByDesc('requests_count')
        ->take(5)
        ->values();


        // our json data has been returned
        return response()->json([
            'total_cars' => Car::count(),

            'available_cars' => Car::where(
                'status',
                'available'
            )->count(),

            'customers' => User::where(
                'role',
                'customer'
            )->count(),

            'pending_purchase_requests' => PurchaseRequest::where(
                'status',
                'pending'
            )->count(),

            'pending_bookings' => Booking::where(
            'status',
            'pending'
            )->count(),

            'unread_messages' => ContactMessage::where(
                'is_read',
                false
            )->count(),

            'latest_pending_bookings' => $latestPendingBookings,
            'latest_purchase_requests' => $latestPurchaseRequests,
            'low_inventory' => $lowInventory,
            'most_requested_cars' => $mostRequestedCars,

        ]);
    }


    public function statistics()
    {
        $completedRequests = PurchaseRequest::with('car')
            ->where('status', 'completed')
            ->get();
        
        // this is for another task , this is belongs to latest five sold cars
        $latestSoldCars = PurchaseRequest::with([
            'car.brand',
            'car.category',
        ])
        ->where('status', 'completed')
        ->latest()
        ->take(5)
        ->get()
        ->map(function ($request) {
            return [
                'id' => $request->id,

                'car' => $request->car?->model ?? 'Unknown',

                'brand' => $request->car?->brand?->name ?? 'Unknown',

                'category' => $request->car?->category?->name ?? 'Unknown',

                'price' => $request->car?->price ?? 0,

                'sold_at' => $request->created_at?->format('Y-m-d'),
            ];
        });
        // end the latest five sold cars section
        
        $carsSold = $completedRequests->count();

        $estimatedSalesValue = $completedRequests->sum(function ($request) {
            return $request->car?->price ?? 0;
        });

        $monthlySales = $completedRequests
            ->groupBy(function ($request) {
                return $request->created_at->format('Y-m');
            })
            ->map(function ($requests, $month) {
                return [
                    'month' => $month,
                    'cars_sold' => $requests->count(),
                    'estimated_sales_value' => $requests->sum(function ($request) {
                        return $request->car?->price ?? 0;
                    }),
                ];
            })
            ->values();

        $annualSales = $completedRequests
            ->groupBy(function ($request) {
                return $request->created_at->format('Y');
            })
            ->map(function ($requests, $year) {
                return [
                    'year' => $year,
                    'cars_sold' => $requests->count(),
                    'estimated_sales_value' => $requests->sum(function ($request) {
                        return $request->car?->price ?? 0;
                    }),
                ];
            })
            ->values();

            $inventoryByBrand = Car::with('brand')
                ->get()
                ->groupBy(function ($car) {
                    return $car->brand?->name ?? 'Unknown';
                })
                ->map(function ($cars, $brand) {
                    return [
                        'brand' => $brand,
                        'cars_count' => $cars->count(),
                    ];
                })
                ->values();

            // this has built on the customer interest
            $mostRequestedCars = PurchaseRequest::with([
                'car.brand',
            ])
                ->get()
                ->groupBy(function ($request) {
                    return $request->car_id;
                })
                ->map(function ($requests) {
                    $car = $requests->first()->car;

                    return [
                        'car' => $car?->model ?? 'Unknown',
                        'brand' => $car?->brand?->name ?? 'Unknown',
                        'requests_count' => $requests->count(),
                    ];
                })
                ->sortByDesc('requests_count')
                ->take(5)
                ->values();


        return response()->json([
            'cars_sold' => $carsSold,

            'estimated_sales_value' => $estimatedSalesValue,

            'monthly_sales' => $monthlySales,

            'annual_sales' => $annualSales,

            'inventory_by_brand' => $inventoryByBrand,

            'latest_sold_cars' => $latestSoldCars,

            'most_requested_cars' => $mostRequestedCars,

        ]);
    }

}
