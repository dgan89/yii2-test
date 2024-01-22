<?php

namespace frontend\modules\notification\models\queries;

use frontend\modules\notification\models\Notification;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[Notification]].
 *
 * @see Notification
 */
class NotificationQuery extends ActiveQuery
{
    /**
     * Поиск по пользователю
     *
     * @param int $value
     * @return NotificationQuery
     */
    public function byUser(int $value): NotificationQuery
    {
        return $this->andWhere(['[[user_id]]' => $value]);
    }

    /**
     * Не прочитанные
     *
     * @return NotificationQuery
     */
    public function unReadied(): NotificationQuery
    {
        return $this->andWhere(['[[is_readied]]' => 0]);
    }

    /**
     * {@inheritdoc}
     * @return Notification[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return array|ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
