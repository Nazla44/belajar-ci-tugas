<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriProdukSeeder extends Seeder
{
    public function run() {
        $data = [
            ['nama' => 'Laptop'],
            ['nama' => 'Printer'],
        ];
        foreach ($data as $item) {
            $this->db->table('kategori_produk')->insert($item);
        }
    }
}
