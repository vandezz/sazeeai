<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubscriptionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'plan' => [
                'type'       => 'ENUM',
                'constraint' => ['free', 'pro', 'agency'],
                'default'    => 'free',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'cancelled', 'expired'],
                'default'    => 'active',
            ],
            'prompts_used' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'prompts_limit' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 10,
            ],
            'starts_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->createTable('subscriptions');
    }

    public function down()
    {
        $this->forge->dropTable('subscriptions');
    }
}
