<?php

#Migration dosyası

namespace SimpleMigration\Database\Migrations;

use SimpleMigration\Migration;

class users_2022_04_03 extends Migration
{
    public function up()
    {
        $this->create('users',[
            $this->id(),
            $this->string('name'),
            $this->string('surname'),
            $this->string('username'),
            $this->int('number'),
            $this->timestamp()
        ]);
    }

    public function down()
    {
        $this->drop('users');
    }

}