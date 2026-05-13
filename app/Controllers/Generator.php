<?php

namespace App\Controllers;

use App\Models\AiPlatformModel;
use App\Models\DesignStyleModel;
use App\Models\PromptModel;
use App\Models\PromptTemplateModel;
use App\Models\SubscriptionModel;
use App\Services\PromptEngineService;

/**
 * Generator Controller — handles the main prompt generation feature.
 */
class Generator extends BaseController
{
    protected AiPlatformModel     $platformModel;
    protected DesignStyleModel    $styleModel;
    protected PromptTemplateModel $templateModel;
    protected PromptModel         $promptModel;
    protected SubscriptionModel   $subModel;
    protected PromptEngineService $engine;

    public function __construct()
    {
        $this->platformModel = new AiPlatformModel();
        $this->styleModel    = new DesignStyleModel();
        $this->templateModel = new PromptTemplateModel();
        $this->promptModel   = new PromptModel();
        $this->subModel      = new SubscriptionModel();
        $this->engine        = new PromptEngineService();
    }

    /**
     * Show the generator form.
     */
    public function index(): string
    {
        return $this->render('generator/index', [
            'platforms' => $this->platformModel->getActive(),
            'styles'    => $this->styleModel->getActive(),
            'templates' => $this->templateModel->getActive(),
            'title'     => 'AI Prompt Generator',
        ]);
    }

    /**
     * Handle form submission and generate the prompt.
     */
    public function generate()
    {
        $rules = [
            'product_name'   => 'required|max_length[255]',
            'brand_name'     => 'permit_empty|max_length[255]',
            'headline'       => 'permit_empty|max_length[255]',
            'subheadline'    => 'permit_empty|max_length[255]',
            'design_style'   => 'required|max_length[100]',
            'ai_platform'    => 'required|max_length[100]',
            'aspect_ratio'   => 'required|max_length[30]',
            'color_theme'    => 'required|max_length[100]',
            'features'       => 'permit_empty',
            'image_count'    => 'permit_empty|integer',
            'image_position' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            // Return JSON for Alpine.js to handle
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        // Check quota for logged-in users
        $userId = session()->get('user_id');
        if ($userId && ! $this->subModel->hasQuota($userId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You have reached your monthly prompt limit. Please upgrade your plan.',
            ]);
        }

        $data = $this->request->getPost();

        // Generate the prompt
        $generatedPrompt = $this->engine->generate($data);

        // Save to DB
        $promptId = $this->promptModel->insert([
            'user_id'             => $userId,
            'title'               => $data['headline'] ?: $data['product_name'],
            'product_name'        => $data['product_name'],
            'brand_name'          => $data['brand_name']          ?? null,
            'headline'            => $data['headline']             ?? null,
            'subheadline'         => $data['subheadline']          ?? null,
            'product_description' => $data['product_description']  ?? null,
            'cta_text'            => $data['cta_text']             ?? null,
            'target_audience'     => $data['target_audience']      ?? null,
            'design_style'        => $data['design_style'],
            'color_theme'         => $data['color_theme'],
            'aspect_ratio'        => $data['aspect_ratio'],
            'ai_platform'         => $data['ai_platform'],
            'image_mood'          => $data['image_mood']           ?? null,
            'typography_style'    => $data['typography_style']     ?? null,
            'lighting_style'      => $data['lighting_style']       ?? null,
            'additional_notes'    => $data['additional_notes']     ?? null,
            'generated_prompt'    => $generatedPrompt,
        ]);

        // Increment usage for logged-in users
        if ($userId) {
            $this->subModel->incrementUsage($userId);
        }

        return $this->response->setJSON([
            'success'  => true,
            'prompt'   => $generatedPrompt,
            'promptId' => $promptId,
        ]);
    }

    /**
     * Download a prompt as a .txt file.
     */
    public function download(int $id)
    {
        $prompt = $this->promptModel->find($id);

        if (! $prompt || $prompt['user_id'] !== session()->get('user_id')) {
            return redirect()->back()->with('error', 'Prompt not found.');
        }

        $filename = 'sazeeai-prompt-' . $id . '.txt';
        $content  = $prompt['generated_prompt'];

        return $this->response
            ->setHeader('Content-Type', 'text/plain')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($content);
    }
}
