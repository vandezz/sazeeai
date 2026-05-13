<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PromptTemplateModel;

class Templates extends BaseController
{
    protected PromptTemplateModel $model;

    public function __construct()
    {
        $this->model = new PromptTemplateModel();
    }

    public function index(): string
    {
        return $this->render('admin/templates/index', [
            'title'     => 'Prompt Templates',
            'templates' => $this->model->orderBy('sort_order', 'ASC')->findAll(),
        ]);
    }

    public function create(): string
    {
        return $this->render('admin/templates/form', ['title' => 'Create Template', 'template' => null]);
    }

    public function store()
    {
        $rules = [
            'name'          => 'required|max_length[150]',
            'template_body' => 'required',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $slug = url_title($this->request->getPost('name'), '-', true);
        $this->model->insert([
            'name'          => $this->request->getPost('name'),
            'slug'          => $slug,
            'category'      => $this->request->getPost('category'),
            'template_body' => $this->request->getPost('template_body'),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
            'is_premium'    => $this->request->getPost('is_premium') ? 1 : 0,
            'sort_order'    => (int) $this->request->getPost('sort_order'),
        ]);

        return redirect()->to(base_url('admin/templates'))->with('success', 'Template created.');
    }

    public function edit(int $id): string
    {
        $template = $this->model->find($id);
        if (! $template) {
            return redirect()->to(base_url('admin/templates'))->with('error', 'Not found.');
        }
        return $this->render('admin/templates/form', ['title' => 'Edit Template', 'template' => $template]);
    }

    public function update(int $id)
    {
        $template = $this->model->find($id);
        if (! $template) {
            return redirect()->to(base_url('admin/templates'))->with('error', 'Not found.');
        }

        $this->model->update($id, [
            'name'          => $this->request->getPost('name'),
            'category'      => $this->request->getPost('category'),
            'template_body' => $this->request->getPost('template_body'),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
            'is_premium'    => $this->request->getPost('is_premium') ? 1 : 0,
            'sort_order'    => (int) $this->request->getPost('sort_order'),
        ]);

        return redirect()->to(base_url('admin/templates'))->with('success', 'Template updated.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('admin/templates'))->with('success', 'Template deleted.');
    }
}
