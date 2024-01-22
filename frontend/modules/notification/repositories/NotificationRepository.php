<?php
declare(strict_types=1);

namespace frontend\modules\notification\repositories;

use common\notification\entities\NotificationInterface;
use common\notification\repositories\NotificationRepositoryInterface;
use frontend\modules\notification\models\Notification;
use frontend\modules\notification\models\queries\NotificationQuery;
use RuntimeException;

/**
 * Class NotificationRepositoryInterface
 * @package common\repositories
 */
class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getOneById(int $id): ?NotificationInterface
    {
        return Notification::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public function save(NotificationInterface $notification)
    {
        if ($notification->save() === false) {
            throw new RuntimeException('Ошибка сохранения уведомления.');
        }
    }

    /**
     * @inheritdoc
     */
    public function getCountUnReadiedByUser(int $userId): int
    {
        return (int)$this
            ->queryUnReadiedByUser($userId)
            ->count();
    }

    /**
     * @inheritDoc
     */
    public function queryUnReadiedByUser(int $userId): NotificationQuery
    {
        return Notification::find()
            ->unReadied()
            ->byUser($userId);
    }

    /**
     * @inheritDoc
     */
    public function setAllAsReadied(int $userId, int $readiedAt)
    {
        Notification::updateAll([
            'is_readied' => true,
            'read_at' => $readiedAt,
        ], [
            'is_readied' => false,
            'user_id' => $userId,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function setAllAsDeleted(int $userId, int $deletedAt)
    {
        Notification::updateAll([
            'is_deleted' => true,
            'deleted_at' => $deletedAt,
        ], [
            'is_deleted' => false,
            'user_id' => $userId,
        ]);
    }
}