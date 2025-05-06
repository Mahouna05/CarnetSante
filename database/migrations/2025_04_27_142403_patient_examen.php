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
        Schema::create('patient_examens', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('date_prch_rdv');
            $table->integer('age');
            $table->integer('temperature');
            $table->integer('poids');
            $table->integer('taille');
            $table->text('observations');
            $table->string('agent');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('patient_id')->on('patient')->onDelete('cascade');
            $table->unsignedBigInteger('examen_id');
            $table->foreign('examen_id')->references('examen_id')->on('examens')->onDelete('cascade');
            $table->unsignedBigInteger('hospital_id');
            $table->foreign('hospital_id')->references('hospital_id')->on('hospital')->onDelete('cascade');
            $table->string('sign_cach');
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
        Schema::dropIfExists('patient_examens');
    }
};
