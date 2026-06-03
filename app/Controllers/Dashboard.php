<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;
use App\Models\PromptModel;
use App\Models\SubscriptionModel;
use App\Models\UserModel;

/**
 * Dashboard Controller — authenticated user area.
 */
class Dashboard extends BaseController
{
    protected UserModel         $userModel;
    protected PromptModel       $promptModel;
    protected SubscriptionModel $subModel;
    protected ActivityLogModel  $logModel;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->promptModel = new PromptModel();
        $this->subModel    = new SubscriptionModel();
        $this->logModel    = new ActivityLogModel();
    }

    public function index(): string
    {
        $userId = session()->get('user_id');
        $user   = $this->userModel->getUserWithSubscription($userId);
        $sub    = $this->subModel->getByUser($userId);

        $recentPrompts = $this->promptModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $totalPrompts = $this->promptModel
            ->where('user_id', $userId)
            ->countAllResults();

        $savedPrompts = $this->promptModel
            ->where('user_id', $userId)
            ->where('is_saved', 1)
            ->countAllResults();

        return $this->render('dashboard/index', [
            'title'         => 'Dashboard',
            'user'          => $user,
            'sub'           => $sub,
            'recentPrompts' => $recentPrompts,
            'totalPrompts'  => $totalPrompts,
            'savedCount'    => $savedPrompts,
        ]);
    }

    public function history(): string
    {
        $userId  = session()->get('user_id');
        $prompts = $this->promptModel->getUserHistory($userId, 15);
        $pager   = $this->promptModel->pager;

        return $this->render('dashboard/history', [
            'title'   => 'Prompt History',
            'prompts' => $prompts,
            'pager'   => $pager,
        ]);
    }

    public function saved(): string
    {
        $userId  = session()->get('user_id');
        $prompts = $this->promptModel->getSavedPrompts($userId);

        return $this->render('dashboard/saved', [
            'title'   => 'Saved Prompts',
            'prompts' => $prompts,
        ]);
    }

    public function savePrompt(int $id)
    {
        $userId = session()->get('user_id');
        $prompt = $this->promptModel->find($id);

        if (! $prompt || $prompt['user_id'] !== $userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not found.']);
        }

        $newState  = $prompt['is_saved'] ? 0 : 1;
        $updateData = ['is_saved' => $newState];

        // Allow optional custom save name when saving (not when unsaving)
        $saveName = trim((string) $this->request->getPost('save_name'));
        if ($newState === 1 && $saveName !== '') {
            $updateData['title'] = $saveName;
        }

        $this->promptModel->update($id, $updateData);

        return $this->response->setJSON([
            'success'   => true,
            'saved'     => (bool) $newState,
            'csrf_hash' => csrf_hash(),
        ]);
    }

    public function renamePrompt(int $id)
    {
        $userId = session()->get('user_id');
        $prompt = $this->promptModel->find($id);

        if (! $prompt || $prompt['user_id'] !== $userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not found.']);
        }

        $newTitle = trim((string) $this->request->getPost('title'));
        if ($newTitle === '') {
            return $this->response->setJSON(['success' => false, 'message' => 'Title cannot be empty.']);
        }

        $this->promptModel->update($id, ['title' => $newTitle]);

        return $this->response->setJSON(['success' => true]);
    }

    public function deletePrompt(int $id)
    {
        $userId = session()->get('user_id');
        $prompt = $this->promptModel->find($id);

        if (! $prompt || $prompt['user_id'] !== $userId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not found.']);
        }

        $this->promptModel->delete($id);

        return $this->response->setJSON(['success' => true]);
    }

    public function profile(): string
    {
        $userId = session()->get('user_id');
        $user   = $this->userModel->find($userId);

        return $this->render('dashboard/profile', [
            'title' => 'My Profile',
            'user'  => $user,
        ]);
    }

    public function updateProfile()
    {
        $userId = session()->get('user_id');
        $rules  = [
            'name'  => 'required|min_length[2]|max_length[150]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
        ];

        if ($this->request->getPost('password')) {
            $rules['password']         = 'min_length[8]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $updateData['password'] = $this->request->getPost('password');
        }

        $this->userModel->skipValidation(true)->update($userId, $updateData);

        // Update session name/email
        session()->set([
            'user_name'  => $updateData['name'],
            'user_email' => $updateData['email'],
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
