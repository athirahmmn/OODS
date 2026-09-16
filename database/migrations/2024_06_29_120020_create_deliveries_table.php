<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id('deliveryID');
            $table->unsignedBigInteger('orderID');
            $table->date('deliveryDate');
            $table->enum('deliveryStatus', ['Preparing your order', 'Out for delivery', 'Delivered']);
            $table->timestamps();

            $table->foreign('orderID')->references('orderID')->on('orders')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
