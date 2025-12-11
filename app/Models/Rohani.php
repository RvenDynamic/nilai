<?php

namespace App\Models;

use CodeIgniter\Model;

class Rohani extends Model
{
    protected $table            = 'rohanis';
    protected $primaryKey       = 'rohani_id';

    protected $allowedFields    = ['anggota_id', 'tahun', 'semester', 'nilai', 'bukti', 'created_at', 'updated_at', 'deleted_at'];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}