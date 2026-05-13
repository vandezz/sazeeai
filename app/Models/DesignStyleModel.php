<?php

namespace App\Models;

use CodeIgniter\Model;

class DesignStyleModel extends Model
{
    protected $table         = 'design_styles';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'slug', 'description', 'prompt_keywords', 'is_active', 'sort_order'];
    protected $useTimestamps = true;

    public function getActive(): array
    {
        return $this->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
    }
}
