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
        Schema::create('employee_academic_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employeeId');
            $table->string('courseOfStudy')->nullable();
            $table->string('intitution')->nullable();
            $table->string('qualification')->nullable();
            $table->date('yearOfGrad')->nullable();
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
        Schema::dropIfExists('employee_academic_records');
    }
};
