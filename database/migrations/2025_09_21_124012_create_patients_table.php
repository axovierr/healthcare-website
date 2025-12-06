<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            
            // Kolom baru untuk relasi ke tabel users
            // Ini adalah kunci FOREIGN KEY yang WAJIB
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade'); 
            
            // Kolom ini tidak boleh dihapus jika masih dibutuhkan untuk identifikasi unik pasien
            $table->string('username')->unique(); 
            
            // Kolom Otentikasi Dihapus (Name, Password, Email)
            // Data ini diambil dari tabel 'users'

            $table->date('birth_date')->nullable(); // Bisa diisi nanti saat melengkapi profil
            $table->string('gender', 20)->nullable(); // Bisa diisi nanti saat melengkapi profil
            $table->string('golongan_darah', 3)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};