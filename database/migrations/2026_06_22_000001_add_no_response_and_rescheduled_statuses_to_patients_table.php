<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("
            ALTER TABLE patients
            MODIFY status ENUM(
                'pendiente',
                'cita_agendada',
                'reagendada',
                'en_consulta',
                'propuesta_cirugia',
                'propuesta_tratamiento',
                'estudios_complementarios',
                'en_seguimiento',
                'contrarreferencia',
                'sin_respuesta',
                'cancelado'
            ) DEFAULT 'pendiente'
        ");
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("
            UPDATE patients
            SET status = 'cita_agendada'
            WHERE status = 'reagendada'
        ");

        DB::statement("
            UPDATE patients
            SET status = 'pendiente'
            WHERE status = 'sin_respuesta'
        ");

        DB::statement("
            ALTER TABLE patients
            MODIFY status ENUM(
                'pendiente',
                'cita_agendada',
                'en_consulta',
                'propuesta_cirugia',
                'propuesta_tratamiento',
                'estudios_complementarios',
                'en_seguimiento',
                'contrarreferencia',
                'cancelado'
            ) DEFAULT 'pendiente'
        ");
    }
};
