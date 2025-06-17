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
        Schema::create('consult', function (Blueprint $table) {
            $table->id('consult_id');
            $table->string('designation');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('consult');
    }
};
