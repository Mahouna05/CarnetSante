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
        Schema::create('examen_vaccin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('examen_id');
            $table->foreign('examen_id')->references('examen_id')->on('examens')->onDelete('cascade');
            $table->unsignedBigInteger('vaccin_id');
            $table->foreign('vaccin_id')->references('vaccin_id')->on('vaccin')->onDelete('cascade');
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
        Schema::dropIfExists('examen_vaccin');
    }
};
