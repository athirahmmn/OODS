<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksOutletTable extends Migration
{
    public function up()
    {
        Schema::create('stocksOutlet', function (Blueprint $table) {
            $table->unsignedBigInteger('stocksID'); // Primary and foreign key
            $table->integer('stocksQuantity');
            $table->integer('minQuantity');
            $table->timestamps();

            $table->primary('stocksID'); // Set as primary key
            $table->foreign('stocksID')->references('stocksID')->on('stocks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stocksOutlet');
    }
}
