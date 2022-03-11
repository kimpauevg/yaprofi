<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 2048);
        });

        Schema::create('prizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_id')->references('id')->on('promos')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('description', 2048);
        });

        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promo_id')->references('id')->on('promos')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
