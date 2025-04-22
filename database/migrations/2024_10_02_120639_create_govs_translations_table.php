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
        Schema::create('govs_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gov_id');
            $table->string('locale')->index();
            $table->unique(['gov_id', 'locale']);
            $table->text('des')->nullable();
            $table->text('small_des')->nullable();
            $table->string('name');
            $table->foreign('gov_id')->references('id')->on('govs')->onDelete('cascade');
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
        Schema::dropIfExists('govs_translations');
    }
};
