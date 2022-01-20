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
            $table->integer('user_id'); //nullable
            $table->integer('merchant_id'); //nullable
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('photo');
            $table->string('description');
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
