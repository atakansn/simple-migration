<?php

#Migration dosyası

namespace SimpleMigration\Database\Migrations;

use SimpleMigration\Migration;

class category_2022_04_05 extends Migration
{
    public function up()
    {
        $this->create('category',[
            $this->id(),
            $this->timestamp()
        ]);
    }

    public function down()
    {
        $this->drop('category');
    }

}