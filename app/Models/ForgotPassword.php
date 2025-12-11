<?php

namespace App\Models;

use CodeIgniter\Model;

class ForgotPassword extends Model
{
    protected $table            = 'forgot_passwords';
    protected $primaryKey       = 'forgot_password_id';

    protected $allowedFields    = ['user_id', 'code', 'created_at', 'updated_at', 'deleted_at'];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}