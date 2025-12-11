<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeed extends Seeder
{
    public function run()
    {
        $data = [
            array(
                'name' => 'satuan fungsi',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            ),
            array(
                'name' => 'admin',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'deleted_at'    => date('Y-m-d H:i:s'),
            )
        ];

    


        // Using Query Builder
        $this->db->table('roles')->insertBatch($data);
    }
}