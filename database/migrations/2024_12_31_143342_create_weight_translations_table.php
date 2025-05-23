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
        Schema::create('weight_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('weight_id');
            $table->string('locale')->index();
            $table->unique(['weight_id', 'locale']);
            $table->string('name');
            $table->foreign('weight_id')->references('id')->on('weights')->onDelete('cascade');
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
        Schema::dropIfExists('weight_translations');
    }
};
