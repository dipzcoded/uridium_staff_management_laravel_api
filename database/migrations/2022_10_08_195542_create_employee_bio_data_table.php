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
            $table->unsignedInteger('employee_id')->unique();
            $table->string('personal_email')->unique();
            $table->string('sex')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('home_address')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
