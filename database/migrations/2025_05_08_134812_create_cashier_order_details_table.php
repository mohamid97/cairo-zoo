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
        Schema::create('cashier_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('cashier_orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('price_before_discount');
            $table->decimal('price_after_discount');
            $table->decimal('total_price_before_discount');
            $table->decimal('total_price_after_discount');
            $table->decimal('quantity');
            $table->enum ('discount_type', ['amount', 'percentage'])->nullable();
            $table->decimal('discount_percentage')->nullable();
            $table->decimal('discount_amount')->nullable();
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
        Schema::dropIfExists('cashier_order_details');
    }

    
};
