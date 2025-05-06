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
        Schema::create('parents_maladies', function (Blueprint $table) {
            $table->id();
            $table->text('observations');
            $table->unsignedBigInteger('parent_id');
            $table->foreign('parent_id')->references('parent_id')->on('parents')->onDelete('cascade');
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
        Schema::dropIfExists('parents_maladies');
    }
};
