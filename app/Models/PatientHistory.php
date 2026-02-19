<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientHistory extends Model
{
    protected $fillable = [
        'patient_id',
        'user_id',
        'event',
        'field',
        'old_value',
        'new_value',
        'snapshot',
    ];

    protected $casts = [
        'snapshot' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
