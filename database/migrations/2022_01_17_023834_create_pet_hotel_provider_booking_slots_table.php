<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetHotelProviderBookingSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_hotel_provider_booking_slots', function (Blueprint $table) {
            $table->id();
            $table->integer('pet_hotel_provider_id');
            $table->integer('user_id'); //id si user yg ngebooking'
            $table->string('check_in_date');
            $table->string('check_out_date');
            $table->string('total_days');
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
        Schema::dropIfExists('pet_hotel_provider_booking_slots');
    }
}
