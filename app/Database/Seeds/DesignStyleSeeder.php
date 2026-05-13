<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DesignStyleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Cinematic Luxury', 'slug' => 'cinematic-luxury', 'prompt_keywords' => 'cinematic, luxury, dramatic lighting, premium, high-end, sophisticated', 'is_active' => 1, 'sort_order' => 1],
            ['name' => 'Minimalist Modern', 'slug' => 'minimalist-modern', 'prompt_keywords' => 'minimalist, clean, modern, white space, simple, elegant, sans-serif typography', 'is_active' => 1, 'sort_order' => 2],
            ['name' => 'Vibrant Pop Art', 'slug' => 'vibrant-pop-art', 'prompt_keywords' => 'vibrant, bold colors, pop art style, energetic, eye-catching, high contrast', 'is_active' => 1, 'sort_order' => 3],
            ['name' => 'Corporate Professional', 'slug' => 'corporate-professional', 'prompt_keywords' => 'corporate, professional, trustworthy, clean, business style, authoritative', 'is_active' => 1, 'sort_order' => 4],
            ['name' => 'Retro Vintage', 'slug' => 'retro-vintage', 'prompt_keywords' => 'retro, vintage, nostalgic, aged texture, warm tones, classic design', 'is_active' => 1, 'sort_order' => 5],
            ['name' => 'Futuristic Tech', 'slug' => 'futuristic-tech', 'prompt_keywords' => 'futuristic, sci-fi, neon glow, tech, holographic, cyberpunk, digital', 'is_active' => 1, 'sort_order' => 6],
            ['name' => 'Natural Organic', 'slug' => 'natural-organic', 'prompt_keywords' => 'natural, organic, earthy tones, botanical, eco-friendly, serene', 'is_active' => 1, 'sort_order' => 7],
            ['name' => 'Playful Fun', 'slug' => 'playful-fun', 'prompt_keywords' => 'playful, fun, colorful, cartoon style, friendly, approachable, youthful', 'is_active' => 1, 'sort_order' => 8],
        ];

        foreach ($data as &$item) {
            $item['created_at'] = date('Y-m-d H:i:s');
            $item['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->db->table('design_styles')->insertBatch($data);
    }
}
