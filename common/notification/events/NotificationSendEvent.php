<?php

namespace common\notification\events;

use common\notification\entities\NotificationInterface;
use yii\base\Event;

/**
 * Событие отправки уведомления
 */
class NotificationSendEvent extends Event
{
    /**
     * @var NotificationInterface
     */
    private NotificationInterface $notification;

    /**
     * @inheritDoc
     */
    public function __construct(NotificationInterface $notification, array $config = [])
    {
        parent::__construct($config);
        $this->notification = $notification;
    }

    /**
     * @return NotificationInterface
     */
    public function getNotification(): NotificationInterface
    {
        return $this->notification;
    }
}