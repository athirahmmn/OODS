<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderdetailsTable extends Migration
{
    public function up()
    {
        Schema::create('orderdetails', function (Blueprint $table) {
            $table->unsignedBigInteger('orderID');
            $table->unsignedBigInteger('stocksID');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('orderID')->references('orderID')->on('orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('stocksID')->references('stocksID')->on('stocks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orderdetails');
    }
}
