<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultAdoptionStatusInPetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Change the default value of the adoption_status column
        DB::statement("ALTER TABLE pets ALTER COLUMN adoption_status SET DEFAULT 'unavailable'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert the default value back to 'available'
        DB::statement("ALTER TABLE pets ALTER COLUMN adoption_status SET DEFAULT 'available'");
    }
}

