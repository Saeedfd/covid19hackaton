<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec("alter table users modify role enum('nurse', 'contact', 'admin') not null; alter table users add set_password enum('0', '1') default '1' null after role;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection()->getPdo()->exec("alter table users modify role enum('nurse', 'contact') not null; alter table users drop column set_password;");
    }
}
