<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rosters', function (Blueprint $table) {
            $table->increments('id');           
            $table->date('date');
            $table->integer('workload');
            $table->time('fromTime');
            $table->time('toTime');

            $table->integer('user_id')->unsigned(); 
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            
            $table->integer('staff_id')->unsigned(); 
            $table->foreign('staff_id')->references('id')->on('staff')
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
        Schema::dropIfExists('rosters');
    }
}
