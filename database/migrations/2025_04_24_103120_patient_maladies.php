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
        Schema::create('patient_maladies', function (Blueprint $table) {
            $table->id();
            $table->string('periode');
            $table->text('observations');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('patient_id')->on('patient')->onDelete('cascade');
            $table->unsignedBigInteger('maladie_id');
            $table->foreign('maladie_id')->references('maladie_id')->on('maladies')->onDelete('cascade');
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
        Schema::dropIfExists('patient_maladies');
    }
};
