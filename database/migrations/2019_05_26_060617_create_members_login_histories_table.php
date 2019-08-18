<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersLoginHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_login_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('login_at')->nullable();
            $table->string('email', 50);
            $table->ipAddress('ip_address');
            $table->dateTime('failed_login_at')->nullable();
            $table->string('not_exist_user', 50);
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
        Schema::dropIfExists('members_login_histories');
    }
}
