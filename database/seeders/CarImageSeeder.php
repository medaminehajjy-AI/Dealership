<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarImage;

class CarImageSeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::all();

        foreach ($cars as $car) {
            CarImage::create([
                'car_id' => $car->id,
                'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7',
            ]);
        }
    }
}
