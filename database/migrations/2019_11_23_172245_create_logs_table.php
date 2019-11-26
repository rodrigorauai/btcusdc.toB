<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_order');
            $table->string('size');
            $table->string('product_id');
            $table->string('side');
            $table->string('done_at');
            $table->string('done_reason');
            $table->string('type');
            $table->string('post_only');
            $table->string('created_at_order');
            $table->string('fill_fees');
            $table->string('filled_size');
            $table->string('executed_value');
            $table->string('status');
            $table->string('settled');
            $table->softDeletes();
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
        Schema::dropIfExists('logs');
    }
}
