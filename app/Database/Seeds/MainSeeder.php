<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('AiPlatformSeeder');
        $this->call('DesignStyleSeeder');
        $this->call('PromptTemplateSeeder');
        $this->call('AdminSeeder');
    }
}
