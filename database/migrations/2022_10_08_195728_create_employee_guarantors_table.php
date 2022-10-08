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
        Schema::create('employee_guarantors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employeeId');
            $table->string('name')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('nin')->nullable();
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
        Schema::dropIfExists('employee_guarantors');
    }
};
