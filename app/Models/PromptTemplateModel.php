<?php

namespace App\Models;

use CodeIgniter\Model;

class PromptTemplateModel extends Model
{
    protected $table         = 'prompt_templates';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'slug', 'category', 'template_body', 'variables', 'is_active', 'is_premium', 'sort_order'];
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
