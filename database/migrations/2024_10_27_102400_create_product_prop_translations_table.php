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
        Schema::create('product_prop_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prop_id');
            $table->string('locale')->index();
            $table->unique(['prop_id', 'locale']);
            $table->string('name');
            $table->text('value');
            $table->foreign('prop_id')->references('id')->on('product_props')->onDelete('cascade');
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
        Schema::dropIfExists('product_prop_translations');
    }
};
