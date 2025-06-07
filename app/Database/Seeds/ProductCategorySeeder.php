<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $data = [
            [
                'nama' => 'Katana 17 B13UDXK-1240ID',
                'harga'  => 14999000,
                'jumlah' => 5,
                'foto' => 'msi_katana_17.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Sword 16 HX B14VEKG-848ID',
                'harga'  => 16499000,
                'jumlah' => 4,
                'foto' => 'msi_sword_16.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Modern 14 F1MG-073/264ID',
                'harga'  => 9499000,
                'jumlah' => 5,
                'foto' => 'msi_Modern_14_F13MG.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ]
        ];

        foreach ($data as $item) {
            // insert semua data ke tabel
            $this->db->table('product_category')->insert($item);
        }
    }
}
