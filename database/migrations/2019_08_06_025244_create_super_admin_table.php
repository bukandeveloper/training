<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuperAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_admin', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('is_online')->default(0);
            $table->string('email', 50)->unique();
            $table->string('password', 80);
            $table->string('name', 200);
            $table->longText('alamat');
            $table->string('telp');
            $table->dateTime('last_access');
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
        Schema::dropIfExists('super_admin');
    }
}
