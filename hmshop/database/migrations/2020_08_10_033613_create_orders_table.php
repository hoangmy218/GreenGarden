<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->Increments('order_id');
            $table->string('order_name');
            $table->string('order_phone');
            $table->date('order_date');
            $table->string('order_note')->nullable();
            $table->double('order_total');
            $table->string('order_address');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('pm_id')->unsigned()->index();
            $table->foreign('pm_id')->references('pm_id')->on('payments');
            $table->integer('st_id')->unsigned()->index();
            $table->foreign('st_id')->references('st_id')->on('order_states');
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
        Schema::dropIfExists('orders');
    }
}
