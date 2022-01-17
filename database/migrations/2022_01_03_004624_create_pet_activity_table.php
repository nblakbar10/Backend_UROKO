<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_activity', function (Blueprint $table) {
            $table->id();
            $table->integer("pet_group_id");
            $table->integer("user_id");
            $table->integer("pet_id");
            $table->string("pet_activity_type");
            $table->string("pet_activity_detail");
            $table->json("pet_activity_image");
            $table->date("pet_activity_date");
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
        Schema::dropIfExists('pet_activity');
    }
}
