<?php

namespace App\Models;

use CodeIgniter\Model;

class UserLog extends Model
{
    protected $table            = 'user_logs';
    protected $primaryKey       = 'user_log_id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['user_id', 'ip_address', 'device', 'created_at', 'updated_at', 'deleted_at'];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
}