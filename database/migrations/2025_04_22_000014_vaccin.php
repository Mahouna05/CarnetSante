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
        Schema::create('vaccin', function (Blueprint $table) {
            $table->id('vaccin_id');
            $table->string('nom');
            $table->string('categorie');
            $table->string('num_de_lot');
            $table->integer('age_requis');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('vaccin');
    }
};
