<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_orders', function (Blueprint $table) {
          
            $table->integer('order_id')->unsigned()->index();
            $table->integer('pro_id')->unsigned()->index();
            $table->integer('qty');
            $table->double('price');
            $table->primary(['order_id', 'pro_id']);
            $table->foreign('order_id')->references('order_id')->on('orders');
            $table->foreign('pro_id')->references('pro_id')->on('products');
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
        Schema::dropIfExists('details_orders');
    }
}
