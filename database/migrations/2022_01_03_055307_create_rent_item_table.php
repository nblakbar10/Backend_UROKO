<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_item', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('pet_id');
            /**$table->string('pet_picture');
            $table->string('pet_name');
            $table->string('pet_age');
            $table->string('pet_species');
            $table->string('pet_breed');
            $table->integer('merchant_id');
            $table->string('merchant_name');
            $table->string('merchant_location');*/
            $table->integer('qty');
            $table->string('description');
            
            $table->integer('rent_item_price');
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
        Schema::dropIfExists('rent_item');
    }
}