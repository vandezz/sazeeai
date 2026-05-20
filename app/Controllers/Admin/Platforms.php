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

    public function create(): string
    {
        return $this->render('admin/platforms/form', [
            'title'    => 'Tambah Platform',
            'platform' => null,
        ]);
    }

    public function store()
    {
        $model = new AiPlatformModel();
        $rules = [
            'name'          => 'required|min_length[2]|max_length[100]',
            'slug'          => 'required|min_length[2]|max_length[100]|is_unique[ai_platforms.slug]',
            'prompt_suffix' => 'permit_empty|max_length[500]',
            'sort_order'    => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $model->insert([
            'name'          => $this->request->getPost('name'),
            'slug'          => url_title($this->request->getPost('slug'), '-', true),
            'description'   => $this->request->getPost('description'),
            'prompt_suffix' => $this->request->getPost('prompt_suffix'),
            'sort_order'    => (int)$this->request->getPost('sort_order') ?: 0,
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        session()->setFlashdata('success', 'Platform berhasil ditambahkan.');
        return redirect()->to(base_url('admin/platforms'));
    }

    public function edit(int $id): string
    {
        $model    = new AiPlatformModel();
        $platform = $model->find($id);
        if (!$platform) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Platform tidak ditemukan.');
        }
        return $this->render('admin/platforms/form', [
            'title'    => 'Edit Platform',
            'platform' => $platform,
        ]);
    }

    public function update(int $id)
    {
        $model    = new AiPlatformModel();
        $platform = $model->find($id);
        if (!$platform) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Platform tidak ditemukan.');
        }

        $slugRule = $this->request->getPost('slug') === $platform['slug']
            ? 'required|min_length[2]|max_length[100]'
            : 'required|min_length[2]|max_length[100]|is_unique[ai_platforms.slug]';

        $rules = [
            'name'          => 'required|min_length[2]|max_length[100]',
            'slug'          => $slugRule,
            'prompt_suffix' => 'permit_empty|max_length[500]',
            'sort_order'    => 'permit_empty|integer',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $model->update($id, [
            'name'          => $this->request->getPost('name'),
            'slug'          => url_title($this->request->getPost('slug'), '-', true),
            'description'   => $this->request->getPost('description'),
            'prompt_suffix' => $this->request->getPost('prompt_suffix'),
            'sort_order'    => (int)$this->request->getPost('sort_order') ?: 0,
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        session()->setFlashdata('success', 'Platform berhasil diperbarui.');
        return redirect()->to(base_url('admin/platforms'));
    }

    public function toggle(int $id)
    {
        $model    = new AiPlatformModel();
        $platform = $model->find($id);
        if ($platform) {
            $model->update($id, ['is_active' => $platform['is_active'] ? 0 : 1]);
        }
        return redirect()->to(base_url('admin/platforms'));
    }

    public function delete(int $id)
    {
        $model = new AiPlatformModel();
        $model->delete($id);
        session()->setFlashdata('success', 'Platform berhasil dihapus.');
        return redirect()->to(base_url('admin/platforms'));
    }
}
