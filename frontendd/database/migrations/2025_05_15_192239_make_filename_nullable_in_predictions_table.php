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
    Schema::table('predictions', function (Blueprint $table) {
        $table->string('filename')->nullable()->change();
    });
}

public function down()
{
    Schema::table('predictions', function (Blueprint $table) {
        $table->string('filename')->nullable(false)->change();
    });
}

};
