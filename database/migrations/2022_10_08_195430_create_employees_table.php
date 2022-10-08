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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('userId');
            $table->string('staffId')->unique()->nullable();
            $table->date('employmentDate')->nullable();
            $table->string('sterlingBankEmail')->unique()->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('grade')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('bankAcctName')->nullable();
            $table->string('bankAcctNumber')->nullable();
            $table->string('bankBvn')->nullable();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('employees');
    }
};
