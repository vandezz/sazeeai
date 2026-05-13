<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $this->db->table('users')->insert([
            'name'       => 'Admin',
            'email'      => 'admin@sazeeai.com',
            'password'   => password_hash('Admin@1234', PASSWORD_BCRYPT),
            'role'       => 'admin',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $adminId = $this->db->insertID();

        // Give admin unlimited subscription
        $this->db->table('subscriptions')->insert([
            'user_id'       => $adminId,
            'plan'          => 'agency',
            'status'        => 'active',
            'prompts_used'  => 0,
            'prompts_limit' => 999999,
            'starts_at'     => date('Y-m-d H:i:s'),
            'expires_at'    => date('Y-m-d H:i:s', strtotime('+100 years')),
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
