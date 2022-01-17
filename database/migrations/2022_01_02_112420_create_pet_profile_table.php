<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_profile', function (Blueprint $table) {
            $table->id();
            $table->string('pet_name');
            $table->integer('user_id');
            $table->string('pet_group_id')->nullable();
            $table->string('pet_gender');
            $table->string('pet_size');
            $table->string('pet_weight');
            $table->string('pet_species');
            $table->string('pet_breed');
            $table->string('pet_morph');
            $table->string('pet_birthdate');
            $table->string('pet_age');
            $table->string('pet_description');
            $table->json('pet_picture');
            $table->string('pet_status');
            $table->string('album_id');
            // $table->string('pet_activity_id');
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
        Schema::dropIfExists('pet_profile');
    }
}
