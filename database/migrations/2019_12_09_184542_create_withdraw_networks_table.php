<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_network', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_withdraw');
            $table->string('name');
            $table->string('value');
            $table->string('fee');
            $table->string('date');
            $table->string('destination_wallet');
            $table->string('email');
            $table->string('type');
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
        Schema::dropIfExists('withdraw_network');
    }
}
