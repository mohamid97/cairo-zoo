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
        Schema::create('partener_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partener_id');
            $table->string('locale')->index();
            $table->unique(['partener_id', 'locale']);
            $table->string('name');
            $table->string('address')->nullable();
            $table->foreign('partener_id')->references('id')->on('parteners')->onDelete('cascade');
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
        Schema::dropIfExists('partener_translations');
    }
};
