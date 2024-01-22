<?php

declare(strict_types=1);

namespace common\notification\repositories;

use common\notification\entities\NotificationInterface;
use yii\db\ActiveQuery;

/**
 * Уведомления
 *
 * Class NotificationRepositoryInterface
 * @package common\repositories
 */
interface NotificationRepositoryInterface
{
    /**
     * @param int $id
     * @return NotificationInterface|null
     */
    public function getOneById(int $id): ?NotificationInterface;

    /**
     * Сохранение уведомления
     *
     * @param NotificationInterface $notification
     * @return void
     */
    public function save(NotificationInterface $notification);

    /**
     * Запрос не прочитанных уведомлений
     *
     * @param int $userId
     * @return ActiveQuery
     */
    public function queryUnReadiedByUser(int $userId): ActiveQuery;

    /**
     * Колличество не прочитанных уведомелний пользователя
     *
     * @param int $userId
     * @return int
     */
    public function getCountUnReadiedByUser(int $userId): int;

    /**
     * Отметить как прочитанные
     *
     * @param int $userId
     * @param int $readiedAt
     * @return void
     */
    public function setAllAsReadied(int $userId, int $readiedAt);

    /**
     * Отметить как удаленные
     *
     * @param int $userId
     * @param int $deletedAt
     * @return void
     */
    public function setAllAsDeleted(int $userId, int $deletedAt);
}