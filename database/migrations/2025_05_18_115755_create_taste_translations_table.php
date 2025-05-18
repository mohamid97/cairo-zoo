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
        Schema::create('taste_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('taste_id');
            $table->string('locale')->index();
            $table->unique(['taste_id', 'locale']);
            $table->text('name');
            $table->text('slug');
            $table->string('des')->nullable();
            $table->foreign('taste_id')->references('id')->on('tastes')->onDelete('cascade');
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
        Schema::dropIfExists('taste_translations');
    }
};
