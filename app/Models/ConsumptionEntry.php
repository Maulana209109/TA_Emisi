<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'factor_items_id',
        'entry_date',
        'emissions',
        'image',
        'metadata',
        'quantity'
    ];

    // Casting agar 'metadata' otomatis jadi JSON/Array dan entry_date jadi tanggal
    protected $casts = [
        'metadata' => 'array',
        'entry_date' => 'datetime',
        'emissions' => 'double',
        'quantity' => 'double',
    ];

    // --- FITUR AGAR OUTPUT JSON SESUAI GAMBAR ---

    // 1. Menambahkan field 'createdAt' (CamelCase) ke dalam JSON
    protected $appends = ['createdAt'];

    // 2. Logic untuk field 'createdAt'
    public function getCreatedAtAttribute()
    {
        return $this->created_at;
    }

    // --- RELASI ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emissionFactor()
    {
        // Menggunakan nama kolom foreign key yang unik sesuai gambar
        return $this->belongsTo(EmissionFactor::class, 'factor_items_id');
    }
}
