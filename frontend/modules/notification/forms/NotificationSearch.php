<?php
declare(strict_types=1);


namespace frontend\modules\notification\forms;

use common\notification\repositories\NotificationRepositoryInterface;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;

/**
 * Поиск уведомлений пользователя
 *
 * Class NotificationSearch
 * @package frontend\modules\notification\forms
 */
class NotificationSearch extends Model
{
    /**
     * @var int|null
     */
    public ?int $searchCategoryId = null;

    /**
     * @var NotificationRepositoryInterface
     */
    private NotificationRepositoryInterface $notifications;

    /**
     * @var int
     */
    private $userId;

    /**
     * @inheritDoc
     */
    public function __construct(
        int                             $userId,
        NotificationRepositoryInterface $notifications,
        array                           $config = []
    )
    {
        parent::__construct($config);

        $this->notifications = $notifications;
        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [
                ['searchCategoryId'], 'filter',
                'filter' => 'intval',
                'skipOnEmpty' => true,
            ],
            [['searchCategoryId'], 'integer'],
        ];
    }

    /**
     * @param array $params
     * @return BaseDataProvider
     */
    public function search(array $params = []): BaseDataProvider
    {
        $query = $this
            ->notifications
            ->queryUnReadiedByUser($this->userId);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'category_id' => $this->searchCategoryId,
        ]);

        return $dataProvider;
    }
}
