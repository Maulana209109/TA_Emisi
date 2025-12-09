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
        Schema::create('emission_factors', function (Blueprint $table) {
            $table->id();
            // Sesuai gambar: "factor_category_id", "name", "value"
            $table->foreignId('factor_category_id')->constrained('emission_categories')->onDelete('cascade');
            $table->string('name');
            $table->double('value'); // Menggunakan double untuk nilai emisi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emission_factors');
    }
};
