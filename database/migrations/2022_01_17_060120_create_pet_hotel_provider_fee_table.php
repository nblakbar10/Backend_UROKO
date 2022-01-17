<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetHotelProviderFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_hotel_provider_fee', function (Blueprint $table) {
            $table->id();
            $table->integer('pet_hotel_provider_id');
            $table->string('pet_type');
            $table->string('pet_size');
            $table->string('slot_available');
            $table->string('price_per_day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pet_hotel_provider_fee');
    }
}
