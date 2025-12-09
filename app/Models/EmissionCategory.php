<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissionCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_name'];

    // Relasi: Satu kategori punya banyak faktor
    public function factors()
    {
        return $this->hasMany(EmissionFactor::class, 'factor_category_id');
    }
}
