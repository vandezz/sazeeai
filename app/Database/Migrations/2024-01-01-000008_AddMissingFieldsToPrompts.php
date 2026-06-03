<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingFieldsToPrompts extends Migration
{
    public function up()
    {
        // Add features, image_count, image_position columns that were missing from prompts table
        $this->forge->addColumn('prompts', [
            'features' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'product_description',
            ],
            'image_count' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'unsigned'   => true,
                'null'       => true,
                'default'    => 1,
                'after'      => 'features',
            ],
            'image_position' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'default'    => 'Center',
                'after'      => 'image_count',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('prompts', ['features', 'image_count', 'image_position']);
    }
}
