<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rohani extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'rohani_id' => [
                'type'           => 'INT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'anggota_id' => [
                'type'       => 'INT',
                'constraint' => 20,
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => '4',
            ],
            'semester' => [
                'type' => 'ENUM("Ganjil", "Genap")',
            ],
            'nilai' => [
                'type' => 'FLOAT',
                'constraint' => '11',
            ],
            'bukti' => [
                'type' => 'TEXT',
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
        $this->forge->addKey('rohani_id', true);
        $this->forge->createTable('rohanis');
    }

    public function down()
    {
        $this->forge->dropTable('rohanis');
    }
}