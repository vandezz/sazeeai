<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PromptModel;
use App\Models\SubscriptionModel;
use App\Models\UserModel;

class Analytics extends BaseController
{
    public function index(): string
    {
        $userModel   = new UserModel();
        $promptModel = new PromptModel();
        $subModel    = new SubscriptionModel();

        // Prompts per day (last 7 days)
        $db = \Config\Database::connect();
        $promptsPerDay = $db->query("
            SELECT DATE(created_at) as date, COUNT(*) as count
            FROM prompts
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
              AND deleted_at IS NULL
            GROUP BY DATE(created_at)
            ORDER BY date ASC
        ")->getResultArray();

        // Platform stats
        $platformStats = $db->query("
            SELECT ai_platform, COUNT(*) as count
            FROM prompts
            WHERE deleted_at IS NULL AND ai_platform IS NOT NULL
            GROUP BY ai_platform
            ORDER BY count DESC
        ")->getResultArray();

        // Plan distribution
        $planStats = $db->query("
            SELECT plan, COUNT(*) as count FROM subscriptions GROUP BY plan
        ")->getResultArray();

        return $this->render('admin/analytics/index', [
            'title'         => 'Analytics',
            'promptsPerDay' => $promptsPerDay,
            'platformStats' => $platformStats,
            'planStats'     => $planStats,
        ]);
    }
}
