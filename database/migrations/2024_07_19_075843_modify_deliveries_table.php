<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDeliveriesTable extends Migration
{
    public function up()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->date('preparing_date')->nullable()->after('deliveryStatus');
            $table->date('out_for_delivery_date')->nullable()->after('preparing_date');
            $table->date('delivered_date')->nullable()->after('out_for_delivery_date');
            $table->date('shipped_date')->nullable()->after('delivered_date');
            $table->string('runnerPhoneNumber', 15)->nullable()->after('shipped_date'); // Add runner_phone_number field
        });
    }

    public function down()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn(['preparing_date', 'out_for_delivery_date', 'delivered_date', 'shipped_date', 'runnerPhoneNumber']); // Drop runner_phone_number field
        });
    }
}
