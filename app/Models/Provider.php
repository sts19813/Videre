<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',

        // Datos del formulario
        'provider_type',
        'clinic_name',
        'contact_name',
        'first_name',
        'last_name',
        'phone',
        'email',

        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /* ======================
     | Accesores útiles
     ====================== */

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
