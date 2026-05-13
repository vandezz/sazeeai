<?php

namespace App\Models;

use CodeIgniter\Model;

class AiPlatformModel extends Model
{
    protected $table         = 'ai_platforms';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'slug', 'description', 'prompt_suffix', 'is_active', 'sort_order'];
    protected $useTimestamps = true;

    public function getActive(): array
    {
        return $this->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
    }

    public function getBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->first();
    }
}
