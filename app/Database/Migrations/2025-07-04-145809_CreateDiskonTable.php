<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDiskonTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','auto_increment'=>true],
            'tanggal' => ['type'=>'DATE','null'=>false],
            'nominal' => ['type'=>'DOUBLE','null'=>false],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('diskon');
    }

    public function down()
    {
        //
    }
}
