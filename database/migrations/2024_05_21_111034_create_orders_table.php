<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('total_price_after_discount', 8, 2);
            $table->decimal('total_price_before_discount', 8, 2);
            $table->decimal('shipment_price', 8, 2);
            $table->enum('payment_method' , ['cash' , 'paymob' , 'else'])->default('cash');
            $table->enum('payment_status' , ['paid' , 'unpaid'])->default('unpaid');
            $table->enum('shipment_way' , ['store' , 'delivery'])->default('store');
            $table->enum('status' , ['pending' , 'finshed'  , 'procced' , 'on-way', 'canceled'])->default('pending');
            $table->string('coupon_code')->nullable();
            $table->decimal('coupon_discount' , 8, 2)->nullable();
            $table->enum ('discount_type', ['amount', 'percentage'])->nullable();
            $table->string('phone');
            $table->string('first_name');
            $table->string('last_name');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
