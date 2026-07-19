<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionFactor extends Model
{
    use HasFactory;

    protected $fillable = [
        'factor_category_id',
        'name',
        'value'
    ];

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(EmissionCategory::class, 'factor_category_id');
    }

    /**
     * Accessor: ekstrak satuan dari nama faktor.
     * Contoh nama: "Mobil (Bensin) (Liter)" → "Liter"
     *              "LPG (Gas Elpiji) (Kg)"  → "Kg"
     *              "Listrik (PLN) (kWh)"    → "kWh"
     */
    public function getUnitAttribute(): string
    {
        // Ambil teks di dalam tanda kurung terakhir
        if (preg_match('/\(([^)]+)\)\s*$/', $this->name, $matches)) {
            return $matches[1];
        }
        return 'unit';
    }
}
