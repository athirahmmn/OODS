<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SetAutoIncrementValues extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE orders AUTO_INCREMENT = 100');
        DB::statement('ALTER TABLE stocks AUTO_INCREMENT = 10');
    }

    public function down()
    {
        // Optionally, you can define how to revert the changes if necessary
        DB::statement('ALTER TABLE orders AUTO_INCREMENT = 1'); // Set back to default if needed
        DB::statement('ALTER TABLE stocks AUTO_INCREMENT = 1'); // Set back to default if needed
    }
}
