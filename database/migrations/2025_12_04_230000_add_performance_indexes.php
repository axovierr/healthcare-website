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
        Schema::table('appointments', function (Blueprint $table) {
            $table->index(['doctor_id', 'date', 'payment_status']);
            $table->index(['date']);
        });

        Schema::table('doctor_sessions', function (Blueprint $table) {
            $table->index(['doctor_id', 'date']);
            $table->index(['date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex(['doctor_id', 'date', 'payment_status']);
            $table->dropIndex(['date']);
        });

        Schema::table('doctor_sessions', function (Blueprint $table) {
            $table->dropIndex(['doctor_id', 'date']);
            $table->dropIndex(['date']);
        });
    }
};
