<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DesignStyleModel;

class Styles extends BaseController
{
    public function index(): string
    {
        $model = new DesignStyleModel();
        return $this->render('admin/styles/index', [
            'title'  => 'Design Styles',
            'styles' => $model->orderBy('sort_order', 'ASC')->findAll(),
        ]);
    }
}
