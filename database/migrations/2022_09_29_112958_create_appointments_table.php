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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            //fk specialty
            $table->foreignId('specialty_id')->constrained('specialties');
            //fk doctor
            $table->foreignId('doctor_id')->constrained('users');
            //fk patient
            $table->foreignId('patient_id')->constrained('users');
            $table->date('scheduled_date');
            $table->time('scheduled_time');
            $table->string('type');
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
        Schema::dropIfExists('appointments');
    }
};
