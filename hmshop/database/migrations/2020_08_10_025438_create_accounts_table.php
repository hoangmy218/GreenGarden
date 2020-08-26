<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->Increments('acc_id');
            $table->string('acc_name');
            $table->string('acc_mail');
            $table->string('acc_password');
            $table->string('acc_phone');
            $table->date('acc_dob');
            $table->string('acc_address');
            $table->integer('role_id')->unsigned()->index();
            $table->foreign('role_id')->references('role_id')->on('roles');
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
        Schema::dropIfExists('accounts');
    }
}
