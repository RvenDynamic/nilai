<?php

namespace App\Models;

use CodeIgniter\Model;

class Satfung extends Model
{
    protected $table            = 'satfungs';
    protected $primaryKey       = 'satfung_id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ["name", "created_at", "updated_at", "deleted_at"];


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