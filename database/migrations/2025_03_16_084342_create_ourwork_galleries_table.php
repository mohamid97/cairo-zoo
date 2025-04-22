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
        Schema::create('ourwork_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('our_work_id');
            $table->string('photo');
            $table->foreign('our_work_id')->references('id')->on('ourworks')->onDelete('cascade');
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
        Schema::dropIfExists('ourwork_galleries');
    }
};
