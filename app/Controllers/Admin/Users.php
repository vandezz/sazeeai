<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubscriptionModel;
use App\Models\UserModel;

class Users extends BaseController
{
    protected UserModel         $userModel;
    protected SubscriptionModel $subModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->subModel  = new SubscriptionModel();
    }

    public function index(): string
    {
        $db = \Config\Database::connect();

        $builder = $db->table('users u')
            ->select('u.id, u.name, u.email, u.role, u.is_active, u.created_at, s.plan, s.prompts_used, s.prompts_limit')
            ->join('subscriptions s', 's.user_id = u.id', 'left')
            ->where('u.deleted_at', null)
            ->orderBy('u.created_at', 'DESC');

        $total  = $builder->countAllResults(false);
        $perPage = 20;
        $page   = (int) ($this->request->getGet('page') ?? 1);
        $offset = ($page - 1) * $perPage;

        $users = $builder->limit($perPage, $offset)->get()->getResultArray();

        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $perPage, $total);

        return $this->render('admin/users/index', [
            'title' => 'Manage Users',
            'users' => $users,
            'pager' => $pager,
        ]);
    }

    public function show(int $id): string
    {
        $user = $this->userModel->getUserWithSubscription($id);
        if (! $user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        return $this->render('admin/users/show', [
            'title' => 'User Detail',
            'user'  => $user,
        ]);
    }

    public function toggle(int $id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return $this->response->setJSON(['success' => false]);
        }

        $newState = $user['is_active'] ? 0 : 1;
        $this->userModel->update($id, ['is_active' => $newState]);

        return $this->response->setJSON(['success' => true, 'active' => (bool) $newState]);
    }

    public function create(): string
    {
        return $this->render('admin/users/create', [
            'title' => 'Tambah Member',
        ]);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[2]|max_length[150]',
            'email'    => 'required|valid_email|max_length[191]|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'plan'     => 'required|in_list[free,pro]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name     = $this->request->getPost('name');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $plan     = $this->request->getPost('plan');

        $id = $this->userModel->insert([
            'name'      => $name,
            'email'     => $email,
            'password'  => $password,
            'role'      => 'user',
            'is_active' => 1,
        ]);

        if (! $id) {
            return redirect()->back()->withInput()->with('error', 'Gagal membuat akun. Silakan coba lagi.');
        }

        if ($plan === 'free') {
            $this->subModel->createFreeSubscription($id);
        } else {
            $this->subModel->createPremiumSubscription($id);
        }

        return redirect()->to(base_url('admin/users/create'))
            ->with('created', [
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
                'plan'     => $plan,
            ]);
    }

    public function setPlan(int $id)
    {
        $plan = $this->request->getPost('plan');
        if (! in_array($plan, ['free', 'pro'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid plan.']);
        }

        $user = $this->userModel->find($id);
        if (! $user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found.']);
        }

        $this->subModel->setPlan($id, $plan);

        return $this->response->setJSON(['success' => true, 'plan' => $plan]);
    }

    public function edit(int $id): string
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        $sub = $this->subModel->where('user_id', $id)->first();

        return $this->render('admin/users/edit', [
            'title' => 'Edit User',
            'user'  => $user,
            'sub'   => $sub,
        ]);
    }

    public function update(int $id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'name'  => 'required|min_length[2]|max_length[150]',
            'email' => 'required|valid_email|max_length[191]|is_unique[users.email,id,' . $id . ']',
            'role'  => 'required|in_list[admin,user]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->skipValidation(true)->update($id, [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'is_active' => (int) (bool) $this->request->getPost('is_active'),
        ]);

        $plan = $this->request->getPost('plan');
        if (in_array($plan, ['free', 'pro'])) {
            $this->subModel->setPlan($id, $plan);
        }

        return redirect()->to(base_url("admin/users/{$id}/edit"))
            ->with('success', 'Perubahan berhasil disimpan.');
    }

    public function resetPassword(int $id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        if (! $this->validate(['new_password' => 'required|min_length[8]'])) {
            return redirect()->back()->with('reset_errors', $this->validator->getErrors());
        }

        $newPassword = $this->request->getPost('new_password');
        $this->userModel->skipValidation(true)->update($id, ['password' => $newPassword]);

        return redirect()->to(base_url("admin/users/{$id}/edit"))
            ->with('reset_success', ['name' => $user['name'], 'password' => $newPassword]);
    }

    public function delete(int $id)
    {
        $authId = (int) session()->get('user_id');
        if ($id === $authId) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);

        return redirect()->to(base_url('admin/users'))
            ->with('success', "User <strong>{$user['name']}</strong> berhasil dihapus.");
    }
}
