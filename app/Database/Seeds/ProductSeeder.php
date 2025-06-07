<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $data = [
            [
                'nama' => 'ASUS TUF A15 FA506NF',
                'harga'  => 10899000,
                'jumlah' => 5,
                'foto' => 'msi_katana_17.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Asus Vivobook 14 A1404ZA',
                'harga'  => 6899000,
                'jumlah' => 7,
                'foto' => 'msi_Modern_14_F13MG.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'Lenovo IdeaPad Slim 3-14IAU7',
                'harga'  => 6299000,
                'jumlah' => 5,
                'foto' => 'lenovo_idepad_slim_3.jpg',
                'created_at' => date("Y-m-d H:i:s"),
            ]
        ];

        foreach ($data as $item) {
            // insert semua data ke tabel
            $this->db->table('product')->insert($item);
        }
    }
}