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
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // relasi ke tabel users
            $table->string('filename'); // nama model (file csv)
            
            // Input prediksi
            $table->float('rata_rata');
            $table->float('mat');
            $table->float('bio');
            $table->float('kim');
            $table->float('big');

            // Sertifikat (file dan penilaian)
            $table->string('certificate_path')->nullable();
            $table->integer('certificate_score')->nullable(); // max 40
            $table->boolean('reviewed')->default(false); // true jika admin sudah memberi nilai

            // Hasil akhir (opsional)
            $table->string('model_prediction')->nullable(); // output dari model, contoh: 'Lulus' / 'Tidak Lulus'
            $table->float('final_score')->nullable(); // 0-100 setelah digabung dengan sertifikat

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
