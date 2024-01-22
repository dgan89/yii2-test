<?php

declare(strict_types=1);

namespace common\notification\services;


use common\notification\dto\NotificationSendData;
use common\notification\events\NotificationSendEvent;
use common\notification\repositories\NotificationRepositoryInterface;
use frontend\modules\notification\models\Notification;
use Throwable;
use Yii;
use yii\base\Component;

/**
 * Сервис уведомлений
 *
 * Class NotificationService
 * @package common\services\notification
 */
class NotificationService extends Component
{
    /** @var string */
    public const EVENT_AFTER_SEND = 'eventAfterSend';

    /**
     * @var NotificationRepositoryInterface
     */
    private NotificationRepositoryInterface $notifications;

    /**
     * @param NotificationRepositoryInterface $notifications
     * @param array $config
     */
    public function __construct(
        NotificationRepositoryInterface $notifications,
        array                           $config = []
    )
    {
        parent::__construct($config);
        $this->notifications = $notifications;
    }

    /**
     * Отправка уведомления пользователю
     *
     * @param int $userId
     * @param NotificationSendData $data
     * @return void
     * @throws Throwable
     */
    public function send(int $userId, NotificationSendData $data)
    {
        $notification = Notification::make(
            $data->title,
            $data->description,
            $userId,
            $data->categoryId
        );

        try {
            $this
                ->notifications
                ->save($notification);

            $event = new NotificationSendEvent($notification);
            $this->trigger(self::EVENT_AFTER_SEND, $event);
        } catch (Throwable $exception) {
            Yii::error($notification->getErrors());

            throw $exception;
        }
    }

    /**
     * Отметить как прочитанные
     *
     * @param int $userId
     * @return void
     */
    public function readAll(int $userId)
    {
        $this
            ->notifications
            ->setAllAsReadied($userId, time());
    }

    /**
     * Очитсить все уведомления
     *
     * @param int $userId
     * @return void
     */
    public function cleanAll(int $userId)
    {
        $this
            ->notifications
            ->setAllAsDeleted($userId, time());
    }
}