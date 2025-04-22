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
        Schema::create('shimpment_company_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shimpment_company_id');
            $table->string('locale')->index();
            $table->unique(['shimpment_company_id', 'locale'], 'shipment_company_id_locale_unique');
            $table->string('name');
            $table->text('details')->nullable();
            $table->foreign('shimpment_company_id')->references('id')->on('shimpment_companies')->onDelete('cascade');
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
        Schema::dropIfExists('shimpment_company_translations');
    }
};
