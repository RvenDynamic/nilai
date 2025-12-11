<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pangkat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pangkat_id' => [
                'type'           => 'INT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
          
        ]);
        $this->forge->addKey('pangkat_id', true);
        $this->forge->createTable('pangkats');
    }

    public function down()
    {
        $this->forge->dropTable('pangkats');
    }
}