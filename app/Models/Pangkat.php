<?php

namespace App\Models;

use CodeIgniter\Model;

class Pangkat extends Model
{
    protected $table            = 'pangkats';
    protected $primaryKey       = 'pangkat_id';
    
    protected $allowedFields    = ['name', 'created_at', 'updated_at', 'deleted_at'];

   

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    
}