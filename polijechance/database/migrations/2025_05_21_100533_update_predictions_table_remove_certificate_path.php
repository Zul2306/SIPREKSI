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
        Schema::table('predictions', function (Blueprint $table) {
            if (Schema::hasColumn('predictions', 'certificate_path')) {
                $table->dropColumn('certificate_path');
            }

            if (!Schema::hasColumn('predictions', 'certificate_score')) {
                $table->float('certificate_score')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->string('certificate_path')->nullable();
            $table->dropColumn('certificate_score');
        });
    }
};
