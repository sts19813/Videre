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

    public function getFieldLabelAttribute()
    {
        return match ($this->field) {
            'status' => 'Estatus',
            'appointment_date' => 'Fecha de cita',
            'appointment_time' => 'Hora de cita',
            'attention_date' => 'Fecha de atención',
            'attention_time' => 'Hora de atención',
            'procedure' => 'Procedimiento',
            'attention_observations' => 'Observaciones médicas',
            default => ucfirst(str_replace('_', ' ', $this->field)),
        };
    }



    private function isDateField()
    {
        return in_array($this->field, [
            'appointment_date',
            'attention_date',
        ]);
    }

    private function isTimeField()
    {
        return in_array($this->field, [
            'appointment_time',
            'attention_time',
        ]);
    }

    public function getOldValueFormattedAttribute()
    {
        return $this->formatValue($this->old_value);
    }

    public function getNewValueFormattedAttribute()
    {
        return $this->formatValue($this->new_value);
    }

    private function formatValue($value)
    {
        if (!$value) {
            return '—';
        }

        // ===============================
        // 1️⃣ Intentar detectar JSON
        // ===============================
        $decoded = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $html = '<ul class="mb-0 ps-4">';

            foreach ($decoded as $key => $val) {

                $label = ucfirst(str_replace('_', ' ', $key));

                // Traducir si/no
                $val = match ($val) {
                    'si' => 'Sí',
                    'no' => 'No',
                    default => $val
                };

                $html .= "<li><strong>{$label}:</strong> {$val}</li>";
            }

            $html .= '</ul>';

            return $html;
        }

        // ===============================
        // 2️⃣ Traducir status
        // ===============================
        $statusMap = [
            'pendiente' => 'Pendiente',
            'cita_agendada' => 'Cita agendada',
            'en_consulta' => 'En consulta',
            'propuesta_cirugia' => 'Cirugía propuesta',
            'propuesta_tratamiento' => 'Tratamiento propuesto',
            'estudios_complementarios' => 'Estudios solicitados',
            'en_seguimiento' => 'En seguimiento',
            'contrarreferencia' => 'Contrarreferencia',
            'cancelado' => 'Cancelado',
        ];

        if (isset($statusMap[$value])) {
            return $statusMap[$value];
        }

        // ===============================
        // 3️⃣ Formatear fechas
        // ===============================
        if ($this->isDateField()) {
            return \Carbon\Carbon::parse($value)->format('d/m/Y');
        }

        // ===============================
        // 4️⃣ Formatear horas
        // ===============================
        if ($this->isTimeField()) {
            return \Carbon\Carbon::parse($value)->format('h:i A');
        }

        return $value;
    }
}
