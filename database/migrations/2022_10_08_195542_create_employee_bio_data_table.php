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
        Schema::create('employee_bio_data', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employeeId');
            $table->string('personalEmail')->unique();
            $table->string('sex')->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->string('stateOfOrigin')->nullable();
            $table->string('maritalStatus')->nullable();
            $table->string('religion')->nullable();
            $table->bigInteger('phoneNumber')->nullable();
            $table->string('homeAddress')->nullable();
            $table->foreign('employeeId')->references('id')->on('employees')->onDelete('cascade');
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
        Schema::dropIfExists('employee_bio_data');
    }
};
