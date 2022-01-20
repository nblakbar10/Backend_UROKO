<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetHotelProviderAmminitiesExtra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_hotel_provider_amminities_extra', function (Blueprint $table) {
            $table->id();
            $table->integer('pet_hotel_provider_id');
            $table->string('extra_amminities_name');
            $table->string('extra_amminities_price_per_day');
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
        Schema::dropIfExists('pet_hotel_provider_amminities_extra');
    }
}
