<?php

namespace App\Services;

use App\Models\AiPlatformModel;
use App\Models\DesignStyleModel;
use App\Models\PromptTemplateModel;

/**
 * PromptEngineService
 *
 * Responsible for generating AI prompts dynamically based on
 * user inputs, design styles, AI platform context, and templates.
 */
class PromptEngineService
{
    protected AiPlatformModel     $platformModel;
    protected DesignStyleModel    $styleModel;
    protected PromptTemplateModel $templateModel;

    public function __construct()
    {
        $this->platformModel = new AiPlatformModel();
        $this->styleModel    = new DesignStyleModel();
        $this->templateModel = new PromptTemplateModel();
    }

    /**
     * Main entry point: generate a structured AI prompt from form data.
     *
     * @param  array  $data  Validated form input
     * @return string        The final generated prompt (JSON)
     */
    public function generate(array $data): string
    {
        $platform  = $this->platformModel->getBySlug($data['ai_platform'] ?? 'midjourney');
        $styleSlug = $this->slugify($data['design_style'] ?? '');
        $style     = $this->styleModel->where('slug', $styleSlug)->first();

        // --- Template-based generation ---
        $templateSlug = $data['template_slug'] ?? '';
        if ($templateSlug) {
            $tpl = $this->templateModel->getBySlug($templateSlug);
            if ($tpl && ! empty($tpl['template_body'])) {
                $vars   = $this->buildVariables($data, $style, $platform);
                $prompt = $this->fillTemplate($tpl['template_body'], $vars);
                // Append platform-specific suffix if set
                if ($platform && ! empty($platform['prompt_suffix'])) {
                    $prompt .= ' ' . trim($platform['prompt_suffix']);
                }
                return $prompt;
            }
        }
        // --- End template-based generation ---

        $platformName  = $platform ? $platform['name'] : ($data['ai_platform'] ?? 'ChatGPT');
        $styleKeywords = $style   ? $style['prompt_keywords'] : ($data['design_style'] ?? 'Modern Professional');

        $productName  = $data['product_name']       ?? '';
        $brandName    = $data['brand_name']          ?? $productName;
        $headline     = $data['headline']            ?? '';
        $subheadline  = $data['subheadline']         ?? '';
        $description  = $data['product_description'] ?? '';
        $cta          = $data['cta_text']            ?? 'Get Started';
        $aspectRatio  = $this->normalizeAspectRatio($data['aspect_ratio'] ?? '1:1');
        $colorTheme   = $data['color_theme']         ?? 'Blue & White';
        $lighting     = $data['lighting_style']      ?? 'Professional studio setup, rim lighting to highlight edges, clean reflection';
        $typography   = $data['typography_style']    ?? 'Modern Sans-Serif';
        $mood         = $data['image_mood']          ?? 'Professional';
        $imageCount   = (int) ($data['image_count']  ?? 1);
        $imagePos     = $data['image_position']      ?? 'Center';
        $notes        = $data['additional_notes']    ?? '';

        // Parse features list
        $featuresRaw  = $data['features'] ?? '';
        $features     = array_values(array_filter(
            array_map('trim', preg_split('/[\n,]+/', $featuresRaw)),
            fn($f) => $f !== ''
        ));

        // Color palette from theme
        [$primaryColor, $bgColor] = $this->extractColors($colorTheme);

        // Composition based on image count
        $compositionStyle  = $this->getCompositionStyle($imageCount);
        $placementRule     = $this->getPlacementRule($imagePos, $imageCount);
        $strictMultiRules  = $this->getMultiImageRules($imageCount);

        // UI elements string
        $featureUiText = count($features) > 0
            ? "Incorporate minimalist floating UI cards, feature icons, or glassmorphism panels to display the features around the product.\nIMPORTANT: Add a premium modern CTA (Call-to-Action) button displaying: '{$cta}'. Make it prominent to encourage user interaction."
            : "IMPORTANT: Add a premium modern CTA (Call-to-Action) button displaying: '{$cta}'. Make it prominent to encourage user interaction.";

        // Aesthetic keywords from style
        $aestheticKeywords = $this->getAestheticKeywords($styleKeywords, $mood);

        // Negative prompt
        $negativePrompt = "ugly, deformed, noisy, blurry, distorted, out of focus, bad anatomy, bad typography, warped products, misspelled words, cluttered background, watermarks, signatures, text artifacts, low resolution";

        // Composition rules
        $compositionRules = [
            "Rule of thirds for balanced layout",
            "Clear visual hierarchy focusing on the product(s) first, then headline",
            "Ensure background does not overpower the product(s)",
        ];
        if ($notes) {
            $compositionRules[] = "Special requirement: {$notes}";
        }

        $output = [
            "task_type"        => "commercial_banner_generation",
            "system_directive" => "You are an elite Commercial Art Director and Graphic Designer. Create a premium product promotional banner based on the exact specifications below. Ensure the provided product image(s) are seamlessly integrated.",
            "model_parameters" => [
                "aspect_ratio"   => $aspectRatio,
                "style_preset"   => $styleKeywords,
                "quality"        => "high",
                "photorealism"   => "ultra-realistic, 8k resolution",
            ],
            "prompt_structure" => [
                "subject"           => "A professional promotional banner for {$productName}",
                "branding_elements" => [
                    "brand_name"   => $brandName,
                    "headline"     => $headline,
                    "subheadline"  => $subheadline,
                    "description"  => $description,
                    "call_to_action" => $cta,
                ],
                "product_visual_layout" => [
                    "expected_images_count"   => $imageCount,
                    "composition_style"       => $compositionStyle,
                    "placement_rule"          => $placementRule,
                    "integration_and_blending"=> "Blend the product(s) seamlessly into the environment with accurate shadows and reflections matching the lighting style.",
                    "strict_multi_image_rules"=> $strictMultiRules,
                ],
                "information_layout" => [
                    "features_to_highlight" => $features,
                    "ui_elements"           => $featureUiText,
                ],
                "visual_style_details" => [
                    "color_palette" => [
                        "primary_accent"        => $primaryColor,
                        "secondary_background"  => $bgColor,
                        "harmony"               => "Create a cohesive color grading using these specific hex colors as the dominant palette.",
                    ],
                    "lighting_setup"   => $this->getLightingDescription($lighting),
                    "aesthetic_keywords" => $aestheticKeywords,
                ],
                "typography_instructions" => "Leave clear negative space for typography. Use {$typography} style. The generated image should either include sleek modern typography for the headline/features, or provide clean areas where text can be overlaid perfectly later.",
                "composition_rules" => $compositionRules,
                "negative_prompt"   => $negativePrompt,
            ],
        ];

        return json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function normalizeAspectRatio(string $ratio): string
    {
        // Extract just the ratio part e.g. "9:16 (Story)" -> "9:16"
        if (preg_match('/(\d+:\d+)/', $ratio, $m)) {
            return $m[1];
        }
        return $ratio;
    }

    protected function extractColors(string $colorTheme): array
    {
        $map = [
            'Gold & Black'         => ['#D4AF37', '#0A0A0A'],
            'Blue & White'         => ['#1E40AF', '#FFFFFF'],
            'Red & Black'          => ['#DC2626', '#111111'],
            'Green & White'        => ['#16A34A', '#FFFFFF'],
            'Purple & Gold'        => ['#7C3AED', '#D4AF37'],
            'Monochrome'           => ['#1F2937', '#F9FAFB'],
            'Pastel Tones'         => ['#F9A8D4', '#FEF3C7'],
            'Neon & Dark'          => ['#22D3EE', '#0F0F0F'],
            'Earthy Tones'         => ['#92400E', '#FEF3C7'],
            'Vibrant Multi-Color'  => ['#F97316', '#8B5CF6'],
        ];
        return $map[$colorTheme] ?? ['#6366f1', '#ffffff'];
    }

    protected function getCompositionStyle(int $count): string
    {
        return match(true) {
            $count === 1 => "Single centered hero product, strong focus composition, clean isolated presentation.",
            $count === 2 => "Dual product side-by-side comparison layout, symmetrical balance, equal visual weight.",
            $count === 3 => "Triangular trio arrangement, hero product centered and larger, two supporting products flanking.",
            default      => "Grid gallery layout, {$count} products arranged in a clean organized composition with clear hierarchy.",
        };
    }

    protected function getPlacementRule(string $position, int $count): string
    {
        if ($count > 1) {
            return "Arrange all {$count} products in a premium dynamic multi-product arrangement with accurate shadows, depth, and perspective.";
        }
        return match($position) {
            'Left'        => "Product positioned on the left third, text and CTA occupy the right two thirds.",
            'Right'       => "Product positioned on the right third, headline and branding on the left.",
            'Bottom'      => "Product anchored at the bottom, headline and branding in the upper portion.",
            'Top'         => "Product at the top, features and CTA below in a structured layout.",
            default       => "Cinematic isometric or floating perspective, creating depth and a premium dynamic arrangement.",
        };
    }

    protected function getMultiImageRules(int $count): array
    {
        if ($count === 1) {
            return ["Focus completely on the single main hero product."];
        }
        return [
            "All {$count} product images MUST be visible and clearly recognizable.",
            "Do NOT merge or blend products into one object — keep each distinct.",
            "Each product must receive balanced lighting consistent with the overall scene.",
            "Maintain proportional sizing — no product should dominate unfairly unless it is the hero.",
        ];
    }

    protected function getAestheticKeywords(string $styleKeywords, string $mood): string
    {
        $moodMap = [
            'Luxurious'        => "Premium luxury feel, rich textures, gold accents",
            'Energetic'        => "Dynamic movement lines, high contrast, powerful energy",
            'Calm & Serene'    => "Soft gradients, ample whitespace, peaceful atmosphere",
            'Bold & Powerful'  => "Strong contrasts, heavy typography weight, impactful visuals",
            'Playful'          => "Fun color pops, rounded elements, approachable design",
            'Professional'     => "Ample negative space, very clean background, Apple-like product presentation, modern sans-serif typography feel, uncluttered",
            'Dark & Moody'     => "Deep shadows, high contrast, cinematic dark atmosphere",
            'Bright & Cheerful'=> "Vibrant colors, clean backgrounds, optimistic visual tone",
        ];
        $moodDesc = $moodMap[$mood] ?? "Ample negative space, very clean background, Apple-like product presentation, modern sans-serif typography feel, uncluttered";
        return $moodDesc . ". Style: {$styleKeywords}.";
    }

    protected function getLightingDescription(string $lighting): string
    {
        $map = [
            'Studio Lighting'   => "Professional studio setup, rim lighting to highlight edges, clean reflection",
            'Cinematic'         => "Cinematic three-point lighting, dramatic depth, film-grade color grading",
            'Soft Diffused'     => "Soft box diffused lighting, gentle shadows, flattering even illumination",
            'Dramatic Shadows'  => "Hard directional lighting, strong cast shadows, high contrast drama",
            'Golden Hour'       => "Warm golden hour natural light, long soft shadows, organic warmth",
            'Neon Glow'         => "Vibrant neon back-lighting, colorful glow halos, futuristic atmosphere",
            'High Key'          => "High key bright lighting, minimal shadows, clean airy feel",
            'Low Key'           => "Low key dark ambient lighting, moody spotlight on product only",
        ];
        return $map[$lighting] ?? $lighting;
    }

    /**
     * Build the variables map from form input and DB context.
     */
    protected function buildVariables(array $data, ?array $style, ?array $platform): array
    {
        $styleKeywords = $style ? $style['prompt_keywords'] : ($data['design_style'] ?? 'modern');
        $platformName  = $platform ? $platform['name'] : ($data['ai_platform'] ?? 'AI');

        return [
            '{{product_name}}'        => $data['product_name']        ?? '',
            '{{brand_name}}'          => $data['brand_name']           ?? '',
            '{{headline}}'            => $data['headline']             ?? '',
            '{{subheadline}}'         => $data['subheadline']          ?? '',
            '{{product_description}}' => $data['product_description']  ?? '',
            '{{cta_text}}'            => $data['cta_text']             ?? 'Buy Now',
            '{{target_audience}}'     => $data['target_audience']      ?? 'general audience',
            '{{design_style}}'        => $styleKeywords,
            '{{color_theme}}'         => $data['color_theme']          ?? 'vibrant',
            '{{aspect_ratio}}'        => $data['aspect_ratio']         ?? '16:9',
            '{{ai_platform}}'         => $platformName,
            '{{image_mood}}'          => $data['image_mood']           ?? 'professional',
            '{{typography_style}}'    => $data['typography_style']     ?? 'modern sans-serif',
            '{{lighting_style}}'      => $data['lighting_style']       ?? 'studio lighting',
            '{{additional_notes}}'    => $data['additional_notes']     ?? '',
        ];
    }

    /**
     * Replace template placeholders with actual values.
     */
    protected function fillTemplate(string $template, array $vars): string
    {
        // Clean empty optional fields so they don't leave blank gaps
        foreach ($vars as $key => $value) {
            if (empty($value)) {
                $vars[$key] = $this->getDefaultForVar($key);
            }
        }

        return str_replace(array_keys($vars), array_values($vars), $template);
    }

    /**
     * Fallback prompt when no template is found.
     */
    protected function buildFallbackPrompt(array $vars): string
    {
        $parts = [];

        $parts[] = "Create a premium {$vars['{{design_style}}']} advertising creative";

        if ($vars['{{product_name}}']) {
            $parts[] = "for {$vars['{{product_name}}']}";
        }
        if ($vars['{{brand_name}}']) {
            $parts[] = "by {$vars['{{brand_name}}']}";
        }

        $parts[] = "with ultra realistic commercial photography style";
        $parts[] = "{$vars['{{color_theme}}']} color palette";
        $parts[] = "{$vars['{{lighting_style}}']} lighting";
        $parts[] = "{$vars['{{typography_style}}']} typography";

        if ($vars['{{headline}}']) {
            $parts[] = "featuring the headline \"{$vars['{{headline}}']}\"";
        }
        if ($vars['{{cta_text}}']) {
            $parts[] = "with CTA \"{$vars['{{cta_text}}']}\"";
        }
        if ($vars['{{target_audience}}']) {
            $parts[] = "targeted at {$vars['{{target_audience}}']}";
        }

        $parts[] = "overall mood: {$vars['{{image_mood}}']}";
        $parts[] = "optimized for {$vars['{{ai_platform}}']}";
        $parts[] = "aspect ratio {$vars['{{aspect_ratio}}']}";
        $parts[] = "8K resolution, ultra detailed, professional branding aesthetic";

        if ($vars['{{additional_notes}}']) {
            $parts[] = "Additional: {$vars['{{additional_notes}}']}";
        }

        return implode(', ', $parts) . '.';
    }

    /**
     * Return sensible default text for empty template variables.
     */
    protected function getDefaultForVar(string $varKey): string
    {
        $defaults = [
            '{{product_name}}'        => 'the product',
            '{{brand_name}}'          => 'the brand',
            '{{headline}}'            => '',
            '{{subheadline}}'         => '',
            '{{product_description}}' => 'a premium product',
            '{{cta_text}}'            => 'Get Started',
            '{{target_audience}}'     => 'general audience',
            '{{design_style}}'        => 'modern professional',
            '{{color_theme}}'         => 'vibrant',
            '{{aspect_ratio}}'        => '16:9',
            '{{ai_platform}}'         => 'Midjourney',
            '{{image_mood}}'          => 'professional',
            '{{typography_style}}'    => 'modern sans-serif',
            '{{lighting_style}}'      => 'studio lighting',
            '{{additional_notes}}'    => '',
        ];

        return $defaults[$varKey] ?? '';
    }

    /**
     * Convert a display name to a slug.
     */
    protected function slugify(string $text): string
    {
        return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $text), '-'));
    }
}
