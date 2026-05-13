<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PromptTemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'name'          => 'Premium Advertising Flyer',
                'slug'          => 'premium-advertising-flyer',
                'category'      => 'flyer',
                'template_body' => 'Create a premium {{design_style}} advertising flyer for {{product_name}} by {{brand_name}}. The flyer features the headline "{{headline}}" with subheadline "{{subheadline}}". Product description: {{product_description}}. Target audience: {{target_audience}}. Include a prominent CTA button saying "{{cta_text}}". Use a {{color_theme}} color palette with {{typography_style}} typography. The overall mood is {{image_mood}} with {{lighting_style}} lighting. Additional requirements: {{additional_notes}}. Optimized for {{ai_platform}}, aspect ratio {{aspect_ratio}}. Ultra realistic, 8K, commercial photography quality, sharp details, professional branding.',
                'is_active'     => 1,
                'sort_order'    => 1,
            ],
            [
                'name'          => 'Social Media Banner',
                'slug'          => 'social-media-banner',
                'category'      => 'social',
                'template_body' => 'Design a high-impact {{design_style}} social media banner for {{brand_name}} promoting {{product_name}}. Bold headline: "{{headline}}". Supporting text: "{{subheadline}}". Tailored for {{target_audience}}. CTA: "{{cta_text}}". Color scheme: {{color_theme}}. Mood: {{image_mood}}. Lighting: {{lighting_style}}. Font style: {{typography_style}}. Notes: {{additional_notes}}. Crisp resolution, eye-catching composition, mobile-first design, optimized for {{ai_platform}}, {{aspect_ratio}} format.',
                'is_active'     => 1,
                'sort_order'    => 2,
            ],
            [
                'name'          => 'Product Launch Poster',
                'slug'          => 'product-launch-poster',
                'category'      => 'poster',
                'template_body' => 'Generate a {{design_style}} product launch poster for {{product_name}} from {{brand_name}}. Main headline: "{{headline}}". Subtitle: "{{subheadline}}". Product details: {{product_description}}. Aimed at {{target_audience}}. Call to action: "{{cta_text}}". Visual palette: {{color_theme}}. Atmosphere: {{image_mood}} with {{lighting_style}} lighting. Typography: {{typography_style}}. Special notes: {{additional_notes}}. Print-ready quality, professional layout, high contrast, optimized for {{ai_platform}}, {{aspect_ratio}} ratio.',
                'is_active'     => 1,
                'sort_order'    => 3,
            ],
            [
                'name'          => 'Email Marketing Header',
                'slug'          => 'email-marketing-header',
                'category'      => 'email',
                'template_body' => 'Create a {{design_style}} email marketing header banner for {{brand_name}} featuring {{product_name}}. Headline text: "{{headline}}". Supporting copy: "{{subheadline}}". Target demographic: {{target_audience}}. CTA text: "{{cta_text}}". Brand colors: {{color_theme}}. Visual mood: {{image_mood}}. Lighting approach: {{lighting_style}}. Font treatment: {{typography_style}}. Special instructions: {{additional_notes}}. Clean layout, high conversion focus, optimized for {{ai_platform}}, {{aspect_ratio}} dimensions.',
                'is_active'     => 1,
                'sort_order'    => 4,
            ],
        ];

        foreach ($templates as &$t) {
            $t['variables']   = json_encode(['product_name', 'brand_name', 'headline', 'subheadline', 'product_description', 'cta_text', 'target_audience', 'design_style', 'color_theme', 'aspect_ratio', 'ai_platform', 'image_mood', 'typography_style', 'lighting_style', 'additional_notes']);
            $t['is_premium']  = 0;
            $t['created_at']  = date('Y-m-d H:i:s');
            $t['updated_at']  = date('Y-m-d H:i:s');
        }

        $this->db->table('prompt_templates')->insertBatch($templates);
    }
}
