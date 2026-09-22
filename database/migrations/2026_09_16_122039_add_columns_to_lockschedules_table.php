<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lockschedules', function (Blueprint $table) {
            //
            $table->foreignId('doctor_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->unsignedTinyInteger('day_of_week'); // 0 (Domingo) a 6 (Sábado)
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lockschedules', function (Blueprint $table) {
            //
        });
    }
};
