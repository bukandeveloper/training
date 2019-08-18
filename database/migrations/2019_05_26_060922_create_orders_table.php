<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('total');
            $table->integer('berat');
            $table->integer('ongkir');
            $table->integer('member_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('member_id')
            ->references('id')->on('members')->onDelete('set null')->onUpdate('set null');
            $table->foreign('status_id')
            ->references('id')->on('order_statuses')->onDelete('set null')->onUpdate('set null');
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
