<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AiPlatformModel;

class Platforms extends BaseController
{
    public function index(): string
    {
        $model = new AiPlatformModel();
        return $this->render('admin/platforms/index', [
            'title'     => 'AI Platforms',
            'platforms' => $model->orderBy('sort_order', 'ASC')->findAll(),
        ]);
    }
}
