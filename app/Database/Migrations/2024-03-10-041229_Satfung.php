<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Satfung extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'satfung_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
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
        $this->forge->addKey('satfung_id', true);
        $this->forge->createTable('satfungs');
    }

    public function down()
    {
        $this->forge->dropTable('satfungs');

    }
}