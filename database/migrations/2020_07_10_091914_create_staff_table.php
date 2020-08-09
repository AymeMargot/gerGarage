<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('gnb');
            $table->string('pps');
            $table->string('showed');
            $table->string('address');
            $table->string('gender');
            $table->string('civilStatus');
            $table->string('photo')->nullable();
            $table->date('birthday');
            $table->integer('user_id')->unsigned(); 
            $table->foreign('user_id')->references('id')->on('users')        
            ->onDelete('cascade'); 
            $table->integer('position')->unsigned(); 
            $table->foreign('position')->references('id')->on('roles')        
            ->onDelete('cascade'); 
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
        Schema::dropIfExists('staff');
    }
}
