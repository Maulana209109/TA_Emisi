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
        Schema::create('consumption_entries', function (Blueprint $table) {
            $table->id();

            // Relasi ke User
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Relasi ke Emission Factor (Nama kolom sesuai gambar: "factor_items_id")
            $table->foreignId('factor_items_id')->constrained('emission_factors')->onDelete('cascade');

            // Field sesuai gambar
            $table->dateTime('entry_date');
            $table->double('emissions');
            $table->string('image')->nullable(); // Untuk path gambar
            $table->json('metadata')->nullable(); // Menyimpan customEfficiency, fuelType, dll
            $table->double('quantity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumption_entries');
    }
};
