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
        Schema::create('patient_consult', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('observations');
            $table->string('agent');
            $table->unsignedBigInteger('consult_id');
            $table->foreign('consult_id')->references('consult_id')->on('consult')->onDelete('cascade');
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
        Schema::dropIfExists('patient_consult');
    }
};
