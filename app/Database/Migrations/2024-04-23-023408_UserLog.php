<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserLog extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_log_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'device' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->addKey('user_log_id', true);
        $this->forge->createTable('user_logs');

    }

    public function down()
    {
        $this->forge->dropTable('user_logs');
    }
}