<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStocksTable extends Migration
{
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn('stocksQuantity');
            $table->dropColumn('minQuantity');
        });
    }

    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->integer('stocksQuantity');
            $table->string('minQuantity', 25);
            $table->dropColumn('image');
        });
    }
}
