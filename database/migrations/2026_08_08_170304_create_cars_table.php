<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brand_id')
                  ->constrained('brands')
                  ->cascadeOnDelete();

            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();

            $table->string('model');
            $table->year('year');
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('mileage')->default(0);

            $table->string('fuel_type')->nullable();
            $table->string('transmission')->nullable();
            $table->string('color')->nullable();

            $table->text('description')->nullable();

            $table->enum('status', ['available', 'sold'])
                  ->default('available');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
