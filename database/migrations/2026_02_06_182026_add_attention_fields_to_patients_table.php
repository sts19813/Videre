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
            $table->date('attention_date')->nullable()->after('status');
            $table->time('attention_time')->nullable()->after('attention_date');
            $table->string('procedure')->nullable()->after('attention_time');
            $table->text('attention_observations')->nullable()->after('procedure');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->date('attention_date')->nullable()->after('status');
            $table->time('attention_time')->nullable()->after('attention_date');
            $table->string('procedure')->nullable()->after('attention_time');
            $table->text('attention_observations')->nullable()->after('procedure');
        });
    }
};
