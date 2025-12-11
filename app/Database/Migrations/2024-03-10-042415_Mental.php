<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mental extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'mental_id' => [
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
        $this->forge->addKey('mental_id', true);
        $this->forge->createTable('mentals');
    }

    public function down()
    {
        $this->forge->dropTable('mentals');
    }
}