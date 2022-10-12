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
            $table->unsignedInteger('user_id')->unique();
            $table->string('staff_id')->unique()->nullable();
            $table->date('employment_date')->nullable();
            $table->string('sterling_bank_email')->unique()->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('grade')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('bank_acct_name')->nullable();
            $table->string('bank_acct_number')->nullable();
            $table->string('bank_bvn')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
