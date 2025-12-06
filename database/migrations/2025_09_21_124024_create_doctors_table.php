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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            // Tambahkan Kunci Asing ke tabel users
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade'); 

            // Kolom Login Dihapus (Name, Email, Password) - Diambil dari tabel 'users'

            $table->string('username')->unique(); 
            $table->string('license_no')->unique();
            $table->string('gender', 20);
            $table->text('address_clinic'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
