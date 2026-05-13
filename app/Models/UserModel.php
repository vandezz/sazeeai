<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'name', 'email', 'password', 'role', 'avatar',
        'is_active', 'reset_token', 'reset_expires', 'last_login',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name'     => 'required|min_length[2]|max_length[150]',
        'email'    => 'required|valid_email|max_length[191]|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[8]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email address is already registered.',
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPasswordIfChanged'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

    protected function hashPasswordIfChanged(array $data): array
    {
        if (isset($data['data']['password']) && ! empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        } elseif (isset($data['data']['password'])) {
            unset($data['data']['password']);
        }
        return $data;
    }

    /**
     * Find user by email (for login).
     */
    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->where('deleted_at', null)->first();
    }

    /**
     * Get user with their subscription info.
     */
    public function getUserWithSubscription(int $userId): ?array
    {
        return $this->db->table('users u')
            ->select('u.*, s.plan, s.status as sub_status, s.prompts_used, s.prompts_limit, s.expires_at')
            ->join('subscriptions s', 's.user_id = u.id', 'left')
            ->where('u.id', $userId)
            ->where('u.deleted_at', null)
            ->get()
            ->getRowArray();
    }
}
