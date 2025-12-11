<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anggota extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'anggota_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nrp' => [
                'type' => 'VARCHAR',
                'constraint' => '14',
                'unique'    => true,
            ],
            'satfung_id' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            'pangkat_id' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'name' => [
                'type' => 'VARCHAR',
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
        $this->forge->addKey('anggota_id', true);
        $this->forge->createTable('anggotas');
    }

    public function down()
    {
        $this->forge->dropTable('anggotas');
    }
}