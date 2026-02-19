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

        'refraction',
        'anterior_segment_findings',
        'posterior_segment_findings',
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

    public function getStatusDateTimeAttribute()
    {
        if ($this->status === 'cita_agendada' && $this->appointment_date && $this->appointment_time) {
            return $this->appointment_date->format('d/m/Y') . ' ' .
                \Carbon\Carbon::parse($this->appointment_time)->format('h:i A');
        }

        if ($this->status === 'atendido' && $this->attention_date && $this->attention_time) {
            return $this->attention_date->format('d/m/Y') . ' ' .
                \Carbon\Carbon::parse($this->attention_time)->format('h:i A');
        }

        return '-';
    }

    public function files()
    {
        return $this->hasMany(PatientFile::class);
    }

    public function histories()
    {
        return $this->hasMany(PatientHistory::class)
            ->latest();
    }

    protected static function booted()
    {
        static::updating(function ($patient) {

            $changes = $patient->getDirty();

            foreach ($changes as $field => $newValue) {

                $oldValue = $patient->getOriginal($field);

                \App\Models\PatientHistory::create([
                    'patient_id' => $patient->id,
                    'user_id' => auth()->id(),
                    'event' => 'updated',
                    'field' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'snapshot' => null,
                ]);
            }
        });
    }

}
