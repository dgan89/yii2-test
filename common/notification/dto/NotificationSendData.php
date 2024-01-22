<?php

namespace common\notification\dto;

use yii\base\BaseObject;

/**
 * Данные для отправки уведомления
 */
class NotificationSendData extends BaseObject
{
    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var int
     */
    public int $categoryId;

}