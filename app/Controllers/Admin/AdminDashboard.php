<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ActivityLogModel;
use App\Models\PromptModel;
use App\Models\SubscriptionModel;
use App\Models\UserModel;

/**
 * Admin Dashboard Controller
 */
class AdminDashboard extends BaseController
{
    public function index(): string
    {
        $userModel   = new UserModel();
        $promptModel = new PromptModel();
        $subModel    = new SubscriptionModel();

        $stats = [
            'total_users'   => $userModel->countAllResults(),
            'total_prompts' => $promptModel->countAllResults(),
            'pro_users'     => $subModel->where('plan', 'pro')->countAllResults(),
            'today_prompts' => $promptModel->where('DATE(created_at)', date('Y-m-d'))->countAllResults(),
        ];

        $recentPrompts = $promptModel->getRecentPrompts(10);
        $recentUsers   = $userModel->orderBy('created_at', 'DESC')->limit(5)->findAll();

        return $this->render('admin/dashboard', [
            'title'         => 'Admin Dashboard',
            'stats'         => $stats,
            'recentPrompts' => $recentPrompts,
            'recentUsers'   => $recentUsers,
        ]);
    }
}
