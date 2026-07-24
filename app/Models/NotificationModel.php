<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'title', 'message', 'link', 'type', 'is_read'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get unread notifications for a user
     */
    public function getUnreadCount(int $userId): int
    {
        return $this->where('user_id', $userId)->where('is_read', 0)->countAllResults();
    }

    /**
     * Get recent notifications for a user
     */
    public function getRecent(int $userId, int $limit = 5)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }

    /**
     * Send notification to a specific user
     */
    public function notify(int $userId, string $title, string $message, ?string $link = null, ?string $type = null)
    {
        return $this->save([
            'user_id' => $userId,
            'title'   => $title,
            'message' => $message,
            'link'    => $link,
            'type'    => $type,
            'is_read' => 0
        ]);
    }

    /**
     * Send notification to multiple users
     */
    public function notifyUsers(array $userIds, string $title, string $message, ?string $link = null, ?string $type = null)
    {
        $data = [];
        foreach ($userIds as $userId) {
            $data[] = [
                'user_id' => $userId,
                'title'   => $title,
                'message' => $message,
                'link'    => $link,
                'type'    => $type,
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        if (!empty($data)) {
            return $this->insertBatch($data);
        }
        return false;
    }
}
