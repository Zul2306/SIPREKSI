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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');                 // Contoh: "X IPA 1"
            $table->unsignedBigInteger('wali_kelas_id')->nullable();  // ID wali kelas dari tabel users
            $table->timestamps();

            // Foreign key ke tabel users (wali kelas)
            $table->foreign('wali_kelas_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null'); // atau set null jika ingin bisa kosong
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
