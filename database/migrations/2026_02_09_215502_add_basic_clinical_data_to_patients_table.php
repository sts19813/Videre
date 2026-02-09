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

            $table->text('refraction')->nullable()->after('clinical_data');
            $table->text('anterior_segment_findings')->nullable();
            $table->text('posterior_segment_findings')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'refraction',
                'anterior_segment_findings',
                'posterior_segment_findings',
            ]);
        });
    }
};
