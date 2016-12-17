<?php

namespace app\modules\events\controllers;

use app\modules\events\components\Tools;
use app\modules\events\models\EventNotices;
use app\modules\events\models\Prepared;
use Yii;
use app\modules\events\models\Messages;
use app\modules\events\models\search\MessagesSearch;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessagesController implements the CRUD actions for Messages model.
 */
class MessagesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Messages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Messages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Messages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Messages();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->message_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Messages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->message_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Messages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Messages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Messages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Messages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return string
     */
    public function actionSendMessages()
    {

        $modelEventPrepared = Yii::$container->get(Prepared::className());
        $countEventPrepared = count(Yii::$app->request->post($modelEventPrepared->formName(), []));
        $modelPrepared = Tools::array_pad([$modelEventPrepared], $countEventPrepared, $modelEventPrepared);

        $modelNotice = Yii::$container->get(EventNotices::className());

        $transaction = Yii::$app->getDb()->beginTransaction();

        try {

            if ($modelNotice->load(Yii::$app->getRequest()->post()) && $modelNotice->save() &&
                Model::loadMultiple($modelPrepared,
                    Tools::reset_keys_array(
                        Yii::$app->request->post(),
                        $modelEventPrepared->formName()
                    )
                )
            ) {

                $modelPrepared = array_map(function(Prepared $item) use ($modelNotice) {
                    $item->setAttributes([
                        'data' => Json::encode([
                            'model' => serialize(new Model()),
                            'sub_data' => Json::encode([]),
                            'user_id' => Yii::$app->getUser()->getId()
                        ]),
                        'notice_id' => $modelNotice->notice_id,
                        'priority' => 'high',
                        'status' => 'wait'
                    ]);
                    return $item;
                },$modelPrepared);

                if (Model::validateMultiple($modelPrepared)) {

                    foreach ($modelPrepared as $itemPrepared) {
                        $itemPrepared->save(false);
                    }

                    $transaction->commit();

                    $this->redirect(['process-send']);

                }

            }

        } catch (\Exception $exception) {
            $transaction->rollBack();
        }

        return $this->render('send',[
            'modelPrepared' => $modelPrepared,
            'modelNotice' => $modelNotice
        ]);

    }

    public function actionProcessSend()
    {

        $output = '';

        return $this->render('process-send',[
            'result' => Yii::$app->consoleRunner->run('events/processes/messages high', $output),
            'output' => $output
        ]);

    }

    public function actionFields($key)
    {
        $model = Yii::$container->get(Prepared::className());
        return $this->renderPartial('fields',[
            'model' => $model,
            'key' => $key
        ]);
    }

}
