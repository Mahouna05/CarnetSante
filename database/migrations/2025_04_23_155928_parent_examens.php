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
        Schema::create('parent_examens', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('observations');
            $table->string('agent');
            $table->unsignedBigInteger('examen_id');
            $table->foreign('examen_id')->references('examen_id')->on('examens')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id');
            $table->foreign('parent_id')->references('parent_id')->on('parents')->onDelete('cascade');
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
        Schema::dropIfExists('parent_examens');
    }
};
