<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ForgotPassword extends Migration
{
    public function up()
    {
            $this->forge->addField([
                'forgot_password_id' => [
                    'type'           => 'INT',
                    'constraint'     => 5,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'user_id' => [
                    'type' => 'INT',
                    'constraint' => 20,
                ],
                'code' => [
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
            $this->forge->addKey('forgot_password_id', true);
            $this->forge->createTable('forgot_passwords');
    }

    public function down()
    {
        $this->forge->dropTable('forgot_passwords');
    }
}