<?php

use App\Models\City;
use App\Models\Barangay;
use App\Models\Province;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Province::class, 'province_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(City::class, 'city_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Barangay::class, 'barangay_id')->constrained()->cascadeOnDelete();
            $table->string('street')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
