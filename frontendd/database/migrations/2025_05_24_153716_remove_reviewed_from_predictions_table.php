<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveReviewedFromPredictionsTable extends Migration
{
    public function up()
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->dropColumn('reviewed');
        });
    }

    public function down()
    {
        Schema::table('predictions', function (Blueprint $table) {
            $table->boolean('reviewed')->default(false);
        });
    }
}
