<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_order', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('username');
            $table->string('phone_number');
            $table->string('address');
            $table->integer('merchant_id');
            $table->string('merchant_name');
            $table->integer('auction_item_id');
            $table->integer('bid_order_set');
            $table->integer('pet_id');
            $table->boolean('bid_status')->default(0)->change();
            $table->string('bid_comments');
            $table->integer('shipping_id');
            $table->string('shipping_type');
            $table->string('shipping_fee');
            $table->integer('grand_total_order');
            $table->string('payments_option');
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
        Schema::dropIfExists('auction_order');
    }
}
