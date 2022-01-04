<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_order', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            
            /**$table->string('username');
            $table->string('phone_number');
            $table->string('address');
            $table->string('merchant_name');
            $table->integer('rent_item_price');
             $table->string('shipping_type');
            $table->string('shipping_fee');*/

            $table->integer('merchant_id');
            
            $table->integer('rent_item_id');
            
            $table->integer('pet_id');

            $table->string('rent_order_start');
            $table->string('rent_order_return');
            $table->string('rent_order_duration');
            $table->string('rent_order_notes');

            $table->integer('shipping_id');
           
            $table->integer('grand_total_order');
            $table->string('payments_option');
            $table->string('rent_order_status');
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
        Schema::dropIfExists('rent_order');
    }
}
