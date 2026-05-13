<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table         = 'activity_logs';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['user_id', 'action', 'description', 'ip_address', 'user_agent'];
    protected $useTimestamps = true;
    protected $updatedField  = '';

    /**
     * Log an activity quickly.
     */
    public function log(string $action, ?string $description = null, ?int $userId = null): void
    {
        $request = service('request');
        $this->insert([
            'user_id'     => $userId ?? session()->get('user_id'),
            'action'      => $action,
            'description' => $description,
            'ip_address'  => $request->getIPAddress(),
            'user_agent'  => substr($request->getUserAgent()->getAgentString(), 0, 500),
        ]);
    }
}
