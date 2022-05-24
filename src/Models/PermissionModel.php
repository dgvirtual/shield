<?php

namespace CodeIgniter\Shield\Models;

use CodeIgniter\Model;
use CodeIgniter\Shield\Entities\User;

class PermissionModel extends Model
{
    protected $table          = 'auth_permissions_users';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields  = [
        'user_id',
        'permission',
        'created_at',
    ];
    protected $useTimestamps      = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getForUser(User $user): array
    {
        $rows = $this->builder()
            ->select('permission')
            ->where('user_id', $user->id)
            ->get()
            ->getResultArray();

        return array_column($rows, 'permission');
    }

    /**
     * @param int|string $userId
     */
    public function deleteAll($userId): void
    {
        $this->builder()
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * @param int|string $userId
     * @param mixed      $cache
     */
    public function deleteNotIn($userId, $cache): void
    {
        $this->builder()
            ->where('user_id', $userId)
            ->whereNotIn('permission', $cache)
            ->delete();
    }
}
