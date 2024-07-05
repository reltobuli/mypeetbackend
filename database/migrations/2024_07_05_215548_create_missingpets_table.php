<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('missingpets', function (Blueprint $table) {
            $table->id();
            $table->string('picture')->nullable();
            $table->string('name');
            $table->string('type');
            $table->string('gender');
            $table->integer('age');
            $table->string('color');
            $table->string('address');
            $table->string('pet_id')->nullable();
            $table->string('qrcode')->nullable();
            $table->boolean('is_missing')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missingpets');
    }
};
