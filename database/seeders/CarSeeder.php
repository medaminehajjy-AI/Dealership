<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;


class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'brand_id' => 1,
                'category_id' => 2,
                'model' => 'RAV4',
                'year' => 2023,
                'price' => 320000,
                'mileage' => 25000,
                'fuel_type' => 'Hybrid',
                'transmission' => 'Automatic',
                'color' => 'White',
                'description' => 'Reliable and comfortable SUV suitable for family and city driving.',
                'status' => 'available',
            ],

            [
                'brand_id' => 2,
                'category_id' => 2,
                'model' => 'X5',
                'year' => 2022,
                'price' => 650000,
                'mileage' => 30000,
                'fuel_type' => 'Diesel',
                'transmission' => 'Automatic',
                'color' => 'Black',
                'description' => 'Luxury SUV combining performance, comfort and modern technology.',
                'status' => 'available',
            ],

            [
                'brand_id' => 3,
                'category_id' => 1,
                'model' => 'C-Class',
                'year' => 2023,
                'price' => 520000,
                'mileage' => 18000,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'color' => 'Silver',
                'description' => 'Elegant sedan with a premium interior and smooth driving experience.',
                'status' => 'available',
            ],

            [
                'brand_id' => 4,
                'category_id' => 1,
                'model' => 'Passat',
                'year' => 2021,
                'price' => 280000,
                'mileage' => 45000,
                'fuel_type' => 'Diesel',
                'transmission' => 'Automatic',
                'color' => 'Grey',
                'description' => 'Practical and comfortable sedan with excellent fuel economy.',
                'status' => 'available',
            ],

            [
                'brand_id' => 5,
                'category_id' => 1,
                'model' => 'A4',
                'year' => 2022,
                'price' => 390000,
                'mileage' => 28000,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'color' => 'Blue',
                'description' => 'Modern premium sedan with excellent performance and technology.',
                'status' => 'available',
            ],

            [
                'brand_id' => 1,
                'category_id' => 1,
                'model' => 'Camry',
                'year' => 2022,
                'price' => 290000,
                'mileage' => 35000,
                'fuel_type' => 'Hybrid',
                'transmission' => 'Automatic',
                'color' => 'Black',
                'description' => 'Comfortable and economical sedan for everyday driving.',
                'status' => 'available',
            ],

            [
                'brand_id' => 2,
                'category_id' => 1,
                'model' => '3 Series',
                'year' => 2023,
                'price' => 450000,
                'mileage' => 20000,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'color' => 'White',
                'description' => 'Sporty luxury sedan with excellent handling and performance.',
                'status' => 'available',
            ],

            [
                'brand_id' => 3,
                'category_id' => 2,
                'model' => 'GLE',
                'year' => 2022,
                'price' => 720000,
                'mileage' => 22000,
                'fuel_type' => 'Diesel',
                'transmission' => 'Automatic',
                'color' => 'Black',
                'description' => 'Premium SUV offering spacious comfort and powerful performance.',
                'status' => 'available',
            ],

            [
                'brand_id' => 4,
                'category_id' => 3,
                'model' => 'Golf',
                'year' => 2023,
                'price' => 250000,
                'mileage' => 15000,
                'fuel_type' => 'Petrol',
                'transmission' => 'Manual',
                'color' => 'Red',
                'description' => 'Compact hatchback with modern technology and excellent handling.',
                'status' => 'available',
            ],

            [
                'brand_id' => 5,
                'category_id' => 4,
                'model' => 'TT',
                'year' => 2021,
                'price' => 410000,
                'mileage' => 32000,
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'color' => 'Red',
                'description' => 'Sporty coupe with a stylish design and strong performance.',
                'status' => 'available',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
