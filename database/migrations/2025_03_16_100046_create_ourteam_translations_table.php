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
        Schema::create('ourteam_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ourteam_id');
            $table->string('locale')->index();
            $table->unique(['ourteam_id', 'locale']);
            $table->text('name');
            $table->text('title');
            $table->string('des');
            $table->foreign('ourteam_id')->references('id')->on('ourteams')->onDelete('cascade');
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
        Schema::dropIfExists('ourteam_translations');
    }
};
