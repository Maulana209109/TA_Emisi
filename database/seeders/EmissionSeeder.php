<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmissionCategory;
use App\Models\EmissionFactor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat User Admin & User Biasa (Opsional, agar mudah login)
        User::create([
            'name' => 'Admin Emisi',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'dailyCarbonLimit' => 0,
        ]);

        $user = User::create([
            'name' => 'User Demo',
            'email' => 'user@test.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'dailyCarbonLimit' => 15.5, // Target harian 15.5 kgCO2
        ]);

        // 2. Data Kategori & Faktor Emisi
        $data = [
            'Transportasi' => [
                ['name' => 'Mobil (Bensin)', 'value' => 2.31, 'unit' => 'Liter'], // 2.31 kgCO2 per Liter
                ['name' => 'Mobil (Solar)', 'value' => 2.68, 'unit' => 'Liter'],
                ['name' => 'Sepeda Motor', 'value' => 1.90, 'unit' => 'Liter'],
                ['name' => 'Bus Umum', 'value' => 0.10, 'unit' => 'KM'], // Per penumpang per KM
            ],
            'Energi Rumah Tangga' => [
                ['name' => 'Listrik (PLN)', 'value' => 0.85, 'unit' => 'kWh'], // Grid Indonesia rata-rata
                ['name' => 'LPG (Gas Elpiji)', 'value' => 2.9, 'unit' => 'Kg'],
            ],
            'Makanan' => [
                ['name' => 'Daging Sapi', 'value' => 27.0, 'unit' => 'Kg'],
                ['name' => 'Daging Ayam', 'value' => 6.9, 'unit' => 'Kg'],
                ['name' => 'Beras/Nasi', 'value' => 2.7, 'unit' => 'Kg'],
                ['name' => 'Sayuran', 'value' => 0.5, 'unit' => 'Kg'],
            ],
            'Limbah' => [
                ['name' => 'Sampah Organik', 'value' => 0.6, 'unit' => 'Kg'],
                ['name' => 'Plastik', 'value' => 6.0, 'unit' => 'Kg'],
            ]
        ];

        foreach ($data as $categoryName => $factors) {
            // Buat Kategori
            $category = EmissionCategory::create(['category_name' => $categoryName]);

            // Buat Faktor di dalam Kategori tersebut
            foreach ($factors as $factor) {
                EmissionFactor::create([
                    'factor_category_id' => $category->id,
                    'name' => $factor['name'] . ' (' . $factor['unit'] . ')', // Misal: Mobil (Bensin) (Liter)
                    'value' => $factor['value'],
                ]);
            }
        }

        // 3. (Opsional) Buat Contoh Data Konsumsi untuk User Demo
        // Agar halaman dashboard tidak kosong saat pertama kali dibuka

        $listrik = EmissionFactor::where('name', 'like', '%Listrik%')->first();
        $motor = EmissionFactor::where('name', 'like', '%Sepeda Motor%')->first();

        if ($listrik && $motor) {
            // Data Hari Ini
            \App\Models\ConsumptionEntry::create([
                'user_id' => $user->id,
                'factor_items_id' => $motor->id,
                'entry_date' => now(),
                'quantity' => 2, // 2 Liter bensin motor
                'emissions' => 2 * $motor->value,
                'metadata' => ['source' => 'seeder_demo'],
            ]);

            // Data Kemarin
            \App\Models\ConsumptionEntry::create([
                'user_id' => $user->id,
                'factor_items_id' => $listrik->id,
                'entry_date' => now()->subDay(),
                'quantity' => 10, // 10 kWh listrik
                'emissions' => 10 * $listrik->value,
                'metadata' => ['source' => 'seeder_demo'],
            ]);
        }
    }
}
