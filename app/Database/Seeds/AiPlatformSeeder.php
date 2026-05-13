<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AiPlatformSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'          => 'ChatGPT / DALL-E',
                'slug'          => 'chatgpt-dalle',
                'description'   => 'OpenAI ChatGPT and DALL-E image generation',
                'prompt_suffix' => 'Generate using DALL-E 3, photorealistic, high quality.',
                'is_active'     => 1,
                'sort_order'    => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Midjourney',
                'slug'          => 'midjourney',
                'description'   => 'Midjourney AI art generation',
                'prompt_suffix' => '--ar 16:9 --style raw --q 2 --v 6',
                'is_active'     => 1,
                'sort_order'    => 2,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Stable Diffusion',
                'slug'          => 'stable-diffusion',
                'description'   => 'Stable Diffusion image generation',
                'prompt_suffix' => '8k resolution, masterpiece, best quality, ultra detailed',
                'is_active'     => 1,
                'sort_order'    => 3,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Flux',
                'slug'          => 'flux',
                'description'   => 'Flux image generation model',
                'prompt_suffix' => 'high resolution, photorealistic, commercial quality',
                'is_active'     => 1,
                'sort_order'    => 4,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Ideogram',
                'slug'          => 'ideogram',
                'description'   => 'Ideogram AI with text rendering',
                'prompt_suffix' => 'sharp text, typographic excellence, vibrant colors',
                'is_active'     => 1,
                'sort_order'    => 5,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => 'Leonardo AI',
                'slug'          => 'leonardo-ai',
                'description'   => 'Leonardo AI creative generation',
                'prompt_suffix' => 'highly detailed, 4k, concept art, trending on artstation',
                'is_active'     => 1,
                'sort_order'    => 6,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('ai_platforms')->insertBatch($data);
    }
}
