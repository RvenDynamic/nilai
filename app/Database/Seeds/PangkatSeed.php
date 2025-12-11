<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PangkatSeed extends Seeder
{
    public function run()
    {
        $data = [
            array(
                'name' => 'Bharada',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Bharatu',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Bharaka',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Abripda',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Abriptu',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Abrip',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Bripda',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Briptu',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Brigpol',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Bripka',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Aipda',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Aiptu',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Ipda',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Iptu',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'AKP',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Kompol',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'AKBP',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'Kombes Pol',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
        ];

    


        // Using Query Builder
        $this->db->table('pangkats')->insertBatch($data);
    }
}