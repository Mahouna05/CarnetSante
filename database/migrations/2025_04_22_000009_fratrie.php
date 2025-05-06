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
        Schema::create('fratrie', function (Blueprint $table) {
            $table->id('fratrie_id');
            $table->date('date_de_naissance')->nullable();
            $table->string('sexe')->nullable();
            $table->string('vivant_sante')->nullable();
            $table->integer('decede_age')->nullable();
            $table->text('decedes_causes')->nullable();
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
        Schema::dropIfExists('fratrie');
    }
};
