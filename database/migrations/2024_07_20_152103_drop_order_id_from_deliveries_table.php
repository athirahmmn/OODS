<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropOrderIdFromDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropForeign(['orderID']); // Drop foreign key constraint if it exists
            $table->dropColumn('orderID'); // Drop the column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->bigInteger('orderID')->unsigned()->nullable();
            $table->foreign('orderID')->references('orderID')->on('orders')->onDelete('cascade');
        });
    }
}
