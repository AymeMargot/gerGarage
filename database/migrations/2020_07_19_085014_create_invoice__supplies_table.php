<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice__supplies', function (Blueprint $table) {
           
            $table->increments('id');
            $table->string('item');
            $table->integer('qty');
            $table->float('price');
            $table->integer('discount')->nullable();
            $table->float('subtotal');
            $table->float('grand_total');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('invoice_id')->unsigned();
            $table->foreign('invoice_id')->references('id')->on('invoices')
                ->onDelete('cascade');
            
            $table->integer('supply_id')->unsigned();
            $table->foreign('supply_id')->references('id')->on('supplies')
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
        Schema::dropIfExists('invoice__supplies');
    }
}
