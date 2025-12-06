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
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['medicine_list', 'note']);
            $table->string('medication');
            $table->string('dosage');
            $table->string('instructions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['medication', 'dosage', 'instructions']);
            $table->text('medicine_list');
            $table->text('note')->nullable();
        });
    }
};
