<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetHotelProviderAmminities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_hotel_provider_amminities', function (Blueprint $table) {
            $table->id();
            $table->integer('pet_hotel_provider_id');
            $table->string('food');
            $table->string('basking');
            $table->string('cleaning');
            $table->string('bedding');
            $table->string('grooming');
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
        Schema::dropIfExists('pet_hotel_provider_amminities');
    }
}
