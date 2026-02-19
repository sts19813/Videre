<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientFile extends Model
{
    protected $fillable = [
        'patient_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
