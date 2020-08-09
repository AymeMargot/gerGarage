<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {

            $table->increments('id');
            $table->string('description');
            $table->date('date');
            $table->string('status');
            $table->string('diagnosis'); 

            $table->integer('user_id')->unsigned();           
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('vehicle_id')->unsigned(); 
            $table->foreign('vehicle_id')->references('id')->on('vehicles')
                ->onDelete('cascade');

            $table->integer('roster_id')->unsigned(); 
            $table->foreign('roster_id')->references('id')->on('rosters')
                ->onDelete('cascade');
                
            $table->integer('bookingtype_id')->unsigned(); 
            $table->foreign('bookingtype_id')->references('id')->on('booking_types')
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
        Schema::dropIfExists('bookings');
    }
}
