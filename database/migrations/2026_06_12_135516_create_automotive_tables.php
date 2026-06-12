<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Cars (Induk)
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('type')->nullable();
            $table->string('transmission')->nullable();
            $table->string('fuel_type')->nullable();
            $table->integer('seats')->nullable();
            $table->decimal('price_per_day', 12, 2);
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });

        // 2. Tabel Rentals (Anak dari Users dan Cars)
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('actual_return_date')->nullable();
            $table->decimal('total_price', 12, 2);
            $table->decimal('fine_amount', 12, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'ongoing', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        // 3. Tabel Payments (Anak dari Rentals)
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals')->cascadeOnDelete();
            $table->enum('payment_type', ['rental_fee', 'fine_payment'])->default('rental_fee');
            $table->string('payment_method');
            $table->decimal('amount', 12, 2);
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'verified', 'failed'])->default('pending');
            $table->timestamps();
        });

        // 4. Tabel Car Maintenances (Anak dari Cars)
        Schema::create('car_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();
            $table->date('maintenance_date');
            $table->text('description');
            $table->decimal('cost', 12, 2);
            $table->timestamps();
        });

        // 5. Tabel Car Reviews (Anak dari Rentals)
        Schema::create('car_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals')->cascadeOnDelete();
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Drop harus dari anak ke induk (kebalikan dari UP)
        Schema::dropIfExists('car_reviews');
        Schema::dropIfExists('car_maintenances');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('rentals');
        Schema::dropIfExists('cars');
    }
};