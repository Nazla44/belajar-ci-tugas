<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KategoriProduk extends Migration
{
    public function up() {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => TRUE,
                'unsigned' => TRUE
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('kategori_produk');
    }

    public function down() {
        $this->forge->dropTable('kategori_produk');
    }
}
