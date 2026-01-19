<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens; // ← WAJIB UNTUK createToken()

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // ← Tambahkan HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profileImage',
        'dailyCarbonLimit',
        'dateOfBirth',
        'lastLogin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dateOfBirth' => 'date',
            'lastLogin' => 'datetime',
            'dailyCarbonLimit' => 'float',
        ];
    }

   

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function consumptionEntries()
    {
        // Asumsi: 1 User memiliki banyak ConsumptionEntry
        return $this->hasMany(ConsumptionEntry::class);
    }
}
