<?php

namespace App\Models;

use CodeIgniter\Model;

class PromptModel extends Model
{
    protected $table            = 'prompts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'user_id', 'title', 'product_name', 'brand_name', 'headline',
        'subheadline', 'product_description', 'cta_text', 'target_audience',
        'design_style', 'color_theme', 'aspect_ratio', 'ai_platform',
        'image_mood', 'typography_style', 'lighting_style', 'additional_notes',
        'generated_prompt', 'template_id', 'is_saved',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Get paginated history for a specific user.
     */
    public function getUserHistory(int $userId, int $perPage = 10): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * Get saved prompts for a specific user.
     */
    public function getSavedPrompts(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->where('is_saved', 1)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Count prompts generated today by user.
     */
    public function countTodayByUser(int $userId): int
    {
        return $this->where('user_id', $userId)
            ->where('DATE(created_at)', date('Y-m-d'))
            ->countAllResults();
    }

    /**
     * Get recent prompts for admin analytics.
     */
    public function getRecentPrompts(int $limit = 20): array
    {
        return $this->db->table('prompts p')
            ->select('p.*, u.name as user_name, u.email as user_email')
            ->join('users u', 'u.id = p.user_id', 'left')
            ->where('p.deleted_at', null)
            ->orderBy('p.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
}
