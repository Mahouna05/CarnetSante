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
        Schema::create('patient_vaccin', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('RDV');
            $table->boolean('etat');
            $table->string('agent');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('patient_id')->on('patient')->onDelete('cascade');
            $table->unsignedBigInteger('vaccin_id');
            $table->foreign('vaccin_id')->references('vaccin_id')->on('vaccin')->onDelete('cascade');
            $table->unsignedBigInteger('hospital_id');
            $table->foreign('hospital_id')->references('hospital_id')->on('hospital')->onDelete('cascade');
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
        Schema::dropIfExists('patient_vaccin');
    }
};
