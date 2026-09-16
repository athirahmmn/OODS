<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orderID');
            $table->unsignedBigInteger('userID');
            $table->date('orderDate');
            $table->integer('orderQuantity');
            $table->enum('orderStatus', ['Approved', 'Pending', 'Rejected']);
            $table->decimal('total', 10, 2);
            $table->timestamps();

            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
