<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionModel extends Model
{
    protected $table         = 'subscriptions';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['user_id', 'plan', 'status', 'prompts_used', 'prompts_limit', 'starts_at', 'expires_at'];
    protected $useTimestamps = true;

    public function getByUser(int $userId): ?array
    {
        return $this->where('user_id', $userId)->first();
    }

    public function incrementUsage(int $userId): void
    {
        $this->db->table('subscriptions')
            ->where('user_id', $userId)
            ->increment('prompts_used', 1);
    }

    public function hasQuota(int $userId): bool
    {
        $sub = $this->getByUser($userId);
        if (! $sub) {
            // Auto-create premium subscription if none exists
            $this->createPremiumSubscription($userId);
            return true;
        }
        return $sub['prompts_used'] < $sub['prompts_limit'];
    }

    /**
     * Create a free-tier subscription when a new user registers.
     */
    public function createFreeSubscription(int $userId): void
    {
        $this->insert([
            'user_id'       => $userId,
            'plan'          => 'free',
            'status'        => 'active',
            'prompts_used'  => 0,
            'prompts_limit' => 10,
            'starts_at'     => date('Y-m-d H:i:s'),
            'expires_at'    => null,
        ]);
    }

    /**
     * Create a premium (unlimited) subscription — for admin-created members.
     */
    public function createPremiumSubscription(int $userId): void
    {
        $this->insert([
            'user_id'       => $userId,
            'plan'          => 'pro',
            'status'        => 'active',
            'prompts_used'  => 0,
            'prompts_limit' => 999999,
            'starts_at'     => date('Y-m-d H:i:s'),
            'expires_at'    => null,
        ]);
    }

    /**
     * Switch an existing user's plan between free and premium.
     */
    public function setPlan(int $userId, string $plan): void
    {
        $limit = ($plan === 'free') ? 10 : 999999;
        $this->where('user_id', $userId)->set([
            'plan'          => $plan,
            'prompts_limit' => $limit,
            'status'        => 'active',
        ])->update();
    }
}
