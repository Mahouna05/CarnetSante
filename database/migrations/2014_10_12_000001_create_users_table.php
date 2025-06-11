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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name');
            $table->string('firstname');
            $table->string('role')->default('agent');
            $table->string('genre')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('hospital')->nullable();
            $table->string('numero_matricule')->nullable();
            $table->string('qualification')->nullable();
            $table->timestamp('date_d_ajout')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->foreign('hospital_id')->references('hospital_id')->on('hospital')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable();;
            $table->foreign('created_by')->references('user_id')->on('users')->onDelete('set null');
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
