<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('license');
            $table->string('name');
            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            
            $table->integer('vehicleType')->unsigned();    
            $table->foreign('vehicleType')->references('id')->on('vehicle_types')
                ->onDelete('cascade');

            $table->integer('brand')->unsigned();
            $table->foreign('brand')->references('id')->on('brands')
                ->onDelete('cascade');
            
            $table->integer('engine')->unsigned();
            $table->foreign('engine')->references('id')->on('engines')
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
        Schema::dropIfExists('vehicles');
    }
}
