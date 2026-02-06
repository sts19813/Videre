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

        // NUEVOS
        'referrer',
        'referral_type',
        'insurance',
        'policy_date',
        'clinical_data',

        'observations',
        'status',

        // citas / atención
        'appointment_date',
        'appointment_time',
        'attention_date',
        'attention_time',
        'procedure',
        'attention_observations',
    ];

    protected $casts = [
        'policy_date' => 'date',
        'clinical_data' => 'array',
        'appointment_date' => 'date',
        'attention_date' => 'date',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
