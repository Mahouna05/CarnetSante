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
        Schema::create('consult_examens', function (Blueprint $table) {
            $table->id();
            $table->date('date'); 
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('patient_id')->on('patient')->onDelete('cascade');
            $table->unsignedBigInteger('consult_id');
            $table->foreign('consult_id')->references('consult_id')->on('consult')->onDelete('cascade');
            $table->unsignedBigInteger('examen_id');
            $table->foreign('examen_id')->references('examen_id')->on('examens')->onDelete('cascade');
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
        Schema::dropIfExists('consult_examens');
    }
};
