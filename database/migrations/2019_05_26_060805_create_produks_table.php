<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_produk', 200);
            $table->string('nama', 200);
            $table->integer('berat')->length(10)->unsigned()->nullable();
            $table->integer('qty')->length(10)->unsigned()->nullable();
            $table->longText('deskripsi')->nullable();
            $table->integer('kategori_id')->unsigned()->nullable();
            $table->foreign('kategori_id')
            ->references('id')->on('kategories')->onDelete('set null')->onUpdate('set null');
            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')
            ->references('id')->on('admins')->onDelete('set null')->onUpdate('set null');
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
        Schema::dropIfExists('produks');
    }
}
