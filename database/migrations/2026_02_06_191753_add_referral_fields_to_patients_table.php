<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {

            // Información del referente
            $table->enum('referrer', [
                'optometrista',
                'oftalmologo',
                'medico_general',
                'otro'
            ])->after('email');

            // Tipo de referido
            $table->enum('referral_type', [
                'consulta_general',
                'cirugia_refractiva',
                'catarata_cristalino',
                'retina'
            ])->after('referrer');

            // Seguro
            $table->enum('insurance', [
                'axxa',
                'allianz',
                'gnp',
                'metlife',
                'atlas',
                'inbursa',
                'sura',
                've_por_mas',
                'seguros_monterrey',
                'seguros_banorte',
                'mapfre',
                'zurich',
                'otro'
            ])->nullable()->after('referral_type');

            $table->date('policy_date')
                ->nullable()
                ->after('insurance');

            // Información clínica dinámica
            $table->json('clinical_data')
                ->nullable()
                ->after('policy_date');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'referrer',
                'referral_type',
                'insurance',
                'policy_date',
                'clinical_data'
            ]);
        });
    }
};
