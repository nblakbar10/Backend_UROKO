<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetHotelOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_hotel_order', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('pet_profile_id');
            $table->string('cage');
            $table->string('pet_caring_note');
            $table->string('check_in_date');
            $table->string('check_out_date');
            $table->string('total_days');
            // $table->integer('pethotel_amminities_selected_id');
            $table->integer('pethotel_order_status');
            $table->integer('pethotel_total_price');
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
        Schema::dropIfExists('pet_hotel_order');
    }
}
