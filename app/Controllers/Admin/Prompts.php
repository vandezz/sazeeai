<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PromptModel;

class Prompts extends BaseController
{
    public function index(): string
    {
        $model   = new PromptModel();
        $prompts = $model->getRecentPrompts(50);

        return $this->render('admin/prompts/index', [
            'title'   => 'All Prompts',
            'prompts' => $prompts,
        ]);
    }
}
