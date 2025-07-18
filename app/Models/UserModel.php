<?php

namespace App\Models;

use CodeIgniter\Model;
//use Myth\Auth\Models\UserModel as MythUserModel;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'password', 'role', 'created_at', 'updated_at'
    ];
}