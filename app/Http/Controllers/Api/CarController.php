<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with([
            'brand',
            'category',
            'images'
        ]);

        // Filter by brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by fuel type
        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        // Filter by transmission
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        // Filter by minimum price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        // Filter by maximum price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search by model
        if ($request->filled('search')) {
            $query->where('model', 'like', '%' . $request->search . '%');
        }

        $cars = $query->paginate(6);

        return response()->json([
            'cars' => $cars
        ]);
    }
    // this is appropriate with the Admin pagination choice
    public function indexAdmin()
    {
        $cars = Car::with([
            'brand',
            'category',
            'images'
        ])->paginate(10);

        return response()->json([
            'cars' => $cars
        ]);
    }
    


        public function show($id)
        {
            $car = Car::with([
                'brand',
                'category',
                'images'
            ])->find($id);

            if (!$car) {
                return response()->json([
                    'message' => 'Car not found'
                ], 404);
            }

            return response()->json([
                'car' => $car
            ]);
        }
    
    public function store(Request $request)
   {
    $validated = $request->validate([
        'brand_id' => 'required|exists:brands,id',
        'category_id' => 'required|exists:categories,id',
        'model' => 'required|string|max:255',
        'year' => 'required|integer|min:1900|max:2100',
        'price' => 'required|numeric|min:0',
        'mileage' => 'required|integer|min:0',
        'fuel_type' => 'required|string|max:50',
        'transmission' => 'required|string|max:50',
        'color' => 'required|string|max:100',
        'description' => 'nullable|string',
        'status' => 'required|in:available,sold,reserved',
    ]);

    $car = Car::create($validated);

    return response()->json([
        'message' => 'Car created successfully',
        'car' => $car->load([
            'brand',
            'category',
            'images'
        ]),
    ], 201);
   }



    public function adminShow($id)
        {
            $car = Car::with([
                'brand',
                'category',
                'images'
            ])->findOrFail($id);

            return response()->json($car);
        }
        
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validated = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100',
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'fuel_type' => 'required|string|max:50',
            'transmission' => 'required|string|max:50',
            'color' => 'required|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|string|max:50',
        ]);

        $car->update($validated);

        return response()->json([
            'message' => 'Car updated successfully.',
            'car' => $car->load([
                'brand',
                'category',
                'images'
            ])
        ]);
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);

        $car->delete();

        return response()->json([
            'message' => 'Car deleted successfully.'
        ]);
    }

    public function uploadImage(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $path = $request->file('image')->store(
            'cars',
            'public'
        );

        $carImage = CarImage::create([
            'car_id' => $car->id,
            'image' => $path,
        ]);

        return response()->json([
            'message' => 'Image uploaded successfully.',
            'image' => $carImage,
        ], 201);
    }

    public function deleteImage($id)
    {
        $carImage = CarImage::findOrFail($id);

        // Delete the physical image from storage
        if ($carImage->image) {
            Storage::disk('public')->delete($carImage->image);
        }

        // Delete the database record
        $carImage->delete();

        return response()->json([
            'message' => 'Image deleted successfully.'
        ]);
    }

    // This is for the Carousel we have implemented 
    public function latest()
    {
        $cars = Car::with([
            'brand',
            'category',
            'images'
        ])
        ->latest()
        ->take(5)
        ->get();

        return response()->json([
            'cars' => $cars
        ]);
    }

}
