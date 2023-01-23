<?php

use SimpleMigration\Migration;

return new class extends Migration {
    public function up()
    {
        $this->schemaCreate('category', [
            $this->id(),
            $this->timestamp()
        ]);
    }

    public function down()
    {
        $this->drop('category');
    }
};
