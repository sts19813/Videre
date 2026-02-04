<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'observations',
        'status',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
