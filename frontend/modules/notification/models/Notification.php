<?php

namespace frontend\modules\notification\models;

use common\entities\User;
use common\helpers\NotificationHelper;
use common\notification\entities\NotificationInterface;
use frontend\modules\notification\models\queries\NotificationQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property string $title Заголовок
 * @property string $description Описание
 * @property int $user_id Пользователь
 * @property int $is_readied Прочитан
 * @property int $is_deleted Удален
 * @property int $category_id Категория
 * @property int $created_at Создано
 *
 * @property User $user
 * @property int $read_at [int(11)]  Прочитано
 * @property int $deleted_at [int(11)]  Удалено
 */
class Notification extends ActiveRecord implements NotificationInterface
{
    const CATEGORY_IMPORTANT = 10;
    const CATEGORY_FINANCE = 20;
    const CATEGORY_PRODUCT = 30;
    const CATEGORY_ADV = 40;
    const CATEGORY_OTHER = 50;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'notification';
    }

    /**
     * @param string $title
     * @param string $description
     * @param int $userId
     * @param int $categoryId
     * @return Notification
     */
    public static function make(
        string $title,
        string $description,
        int    $userId,
        int    $categoryId
    ): Notification
    {
        return new self([
            'title' => $title,
            'description' => $description,
            'user_id' => $userId,
            'category_id' => $categoryId,
            'is_readied' => false,
            'is_deleted' => false,
            'created_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'user_id' => 'Пользователь',
            'is_readied' => 'Прочитан',
            'is_deleted' => 'Удален',
            'category_id' => 'Категория',
            'created_at' => 'Создано',
            'read_at' => 'Создано',
            'deleted_at' => 'Создано',
        ];
    }

    /**
     * {@inheritdoc}
     * @return NotificationQuery the active query used by this AR class.
     */
    public static function find(): NotificationQuery
    {
        return new NotificationQuery(get_called_class());
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function isReadied(): bool
    {
        return (bool)$this->is_readied;
    }

    /**
     * @inheritDoc
     */
    public function getCategory(): string
    {
        return NotificationHelper::getCategoryTitle($this->category_id);
    }
}
