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
        

        Schema::create('patient', function (Blueprint $table) {
            $table->id('patient_id');
            $table->string('numero_de_suivi')->unique();;
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->date('date_de_naissance');
            $table->string('duree_de_l_accouchement');
            $table->string('gender');
            $table->string('lieu_de_naissance');
            $table->binary('empreinte_digitale')->nullable();
            $table->string('motdepasse', 255)->nullable();
            $table->string('qr_code')->nullable();
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
        Schema::dropIfExists('patient');
    }
};
