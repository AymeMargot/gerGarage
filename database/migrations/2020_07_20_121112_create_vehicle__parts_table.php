<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle__parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('stock');
            $table->float('price');
            $table->string('photo'); 

            $table->integer('user_id')->unsigned();       
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')->references('id')->on('brands')
                ->onDelete('cascade');
            
            $table->integer('vehicletype_id')->unsigned();
            $table->foreign('vehicletype_id')->references('id')->on('vehicle_types')
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
        Schema::dropIfExists('vehicle__parts');
    }
}
