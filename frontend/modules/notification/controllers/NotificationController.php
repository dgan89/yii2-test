<?php
declare(strict_types=1);

namespace frontend\modules\notification\controllers;

use common\notification\services\notification\NotificationService;
use frontend\modules\notification\forms\NotificationSearch;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Уведомления пользователоя
 *
 * Class NotificationController
 * @package frontend\controllers
 */
class NotificationController extends Controller
{
    /**
     * @var NotificationService
     */
    private NotificationService $notification;

    /**
     * @inheritDoc
     */
    public function __construct(
        $id,
        $module,
        NotificationService $notification,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->notification = $notification;
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'clean-all' => ['POST'],
                    'read-all' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Список уведомлений
     *
     * @return string
     * @throws InvalidConfigException
     */
    public function actionIndex(): string
    {
        $request = Yii::$app->request;
        $searchModel = Yii::createObject(NotificationSearch::class, [
            'userId' => Yii::$app->user->id,
        ]);
        $dataProvider = $searchModel->search($request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Пометить все как прочитанные
     *
     * @return Response
     */
    public function actionReadAll(): Response
    {
        $userId = Yii::$app->user->id;
        $this->notification->readAll($userId);

        return $this->redirect(['index']);
    }

    /**
     * Удалить все уведомления
     *
     * @return Response
     */
    public function actionCleanAll(): Response
    {
        $userId = Yii::$app->user->id;
        $this->notification->cleanAll($userId);

        return $this->redirect(['index']);
    }
}