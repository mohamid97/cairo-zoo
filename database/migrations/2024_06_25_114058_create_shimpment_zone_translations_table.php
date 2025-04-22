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
        Schema::create('shimpment_zone_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shimpment_zone_id');
            $table->string('locale')->index();
            $table->unique(['shimpment_zone_id', 'locale']);
            $table->string('name');
            $table->text('details')->nullable();
            $table->foreign('shimpment_zone_id')->references('id')->on('shimpment_zones')->onDelete('cascade');
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
        Schema::dropIfExists('shimpment_zone_translations');
    }
};
