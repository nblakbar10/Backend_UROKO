<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetHotelProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_hotel_provider', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('merchant_id');
            $table->string('address');
            $table->string('phone');
            $table->string('desciption');
            $table->string('pet_hotel_provider_photo');
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
        Schema::dropIfExists('pet_hotel_provider');
    }
}
