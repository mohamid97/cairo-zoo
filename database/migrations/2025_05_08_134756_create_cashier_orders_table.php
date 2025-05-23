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
        Schema::create('cashier_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('coupon_code')->nullable();
            $table->decimal('coupon_discount')->nullable();
            $table->decimal('total_amount_before_discount')->nullable();
            $table->decimal('total_amount_after_discount')->nullable();
            $table->decimal('total_discount')->nullable();
            $table->enum('status' , [ 'finshed'  ,'canceled' , 'retrieval'])->default('finshed');
            $table->text('message_retrieval')->nullable();

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
        Schema::dropIfExists('cashier_orders');
    }
};
