<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->Increments('pro_id');
            $table->string('pro_name');
            $table->text('pro_des');
            $table->double('pro_price');
            $table->integer('pro_stock');
            $table->string('pro_image');
            $table->integer('cate_id')->unsigned();
            $table->foreign('cate_id')->references('cate_id')->on('categories');
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
        Schema::dropIfExists('products');
    }
}
