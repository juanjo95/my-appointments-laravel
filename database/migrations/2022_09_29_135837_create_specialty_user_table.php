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
        Schema::create('specialty_user', function (Blueprint $table) {
            $table->id();

            //Doctor
            //$table->unsignedInteger('user_id');
            //$table->foreign('user_id')->references('id')->on('users');

            //Speciality
            //$table->unsignedInteger('specialty_id');
            //$table->foreign('specialty_id')->references('id')->on('specialties');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('specialty_id')->constrained();
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
        Schema::dropIfExists('specialty_user');
    }
};
