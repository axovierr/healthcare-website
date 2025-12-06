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
            $table->decimal('consultation_fee', 12, 2)->default(0)->after('status');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired'])->default('pending')->after('consultation_fee');
            $table->string('va_number')->nullable()->after('payment_status');
            $table->string('payment_url')->nullable()->after('va_number');
            $table->timestamp('paid_at')->nullable()->after('payment_url');
            $table->timestamp('expired_at')->nullable()->after('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'consultation_fee',
                'payment_status',
                'va_number',
                'payment_url',
                'paid_at',
                'expired_at',
            ]);
        });
    }
};
