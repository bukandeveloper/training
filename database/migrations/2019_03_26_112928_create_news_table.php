<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('content');
            $table->datetime('publication_date')->nullable()->default(null);
            $table->string('url', 255);
            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')
            ->references('id')->on('admins')->onDelete('set null')->onUpdate('set null');
            $table->integer('kategori_id')->unsigned()->nullable();
            $table->foreign('kategori_id')
            ->references('id')->on('news_kategories')->onDelete('set null')->onUpdate('set null');
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
        Schema::dropIfExists('news');
    }
}
