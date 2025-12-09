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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom dengan nama camelCase (sesuai gambar)
            $table->string('profileImage')->nullable()->after('password');
            $table->double('dailyCarbonLimit')->default(0)->after('profileImage');
            $table->date('dateOfBirth')->nullable()->after('dailyCarbonLimit');
            $table->timestamp('lastLogin')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn(['profileImage', 'dailyCarbonLimit', 'dateOfBirth', 'lastLogin']);
        });
    }
};
