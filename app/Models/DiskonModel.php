<?php
namespace App\Models;

use CodeIgniter\Model;

class DiskonModel extends Model
{
    protected $table = 'diskon';
    protected $useTimestamps = true;
    protected $allowedFields = ['tanggal', 'nominal'];

    public function hariIni()
    {
        return $this->where('tanggal', date('Y-m-d'))->first();
    }
}
