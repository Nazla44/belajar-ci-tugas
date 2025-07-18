<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $db = db_connect();
        $today = new \CodeIgniter\I18n\Time('now', 'Asia/Jakarta');

        for ($i = 0; $i < 10; $i++) {
            $db->table('diskon')->insert([
                'tanggal' => $today->addDays($i)->toDateString(),
                'nominal' => 100000,
                'created_at' => $today,
                'updated_at' => $today
            ]);
        }    
    }
}
