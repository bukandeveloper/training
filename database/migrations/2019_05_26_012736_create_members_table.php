<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('is_online')->default(0);
            $table->string('email', 50)->unique();
            $table->string('password', 80);
            $table->string('name', 200);
            $table->longText('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->dateTime('last_access')->nullable();
            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')
            ->references('id')->on('admins')->onDelete('set null')->onUpdate('set null');
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
