<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('car_maintenances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('car_id')->constrained()->cascadeOnDelete();
        $table->date('maintenance_date');
        $table->text('description')->nullable();
        $table->decimal('cost', 10, 2)->default(0);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('car_maintenances');
}
};
