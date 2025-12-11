<?php

namespace App\Models;

use CodeIgniter\Model;

class Anggota extends Model
{
    protected $table            = 'anggotas';
    protected $primaryKey       = 'anggota_id';
    protected $allowedFields    = ['nrp', 'name', 'jabatan', 'pangkat_id','satfung_id', 'created_at', 'updated_at', 'deleted_at'];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}