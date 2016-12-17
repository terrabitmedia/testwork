<?php

namespace app\modules\events\controllers;

use app\modules\events\components\Tools;
use app\modules\events\models\EventAssignment;
use app\modules\events\models\EventNotices;
use app\modules\events\models\EventRules;
use Yii;
use app\modules\events\models\Events;
use app\modules\events\models\search\EventsSearch;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminController implements the CRUD actions for Events model.
 */
class AdminController extends Controller
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
     * Lists all Events models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Events model.
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
     * Creates a new Events model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Yii::$container->get(Events::className());
        $modelNotices = Yii::$container->get(EventNotices::className());

        $modelEventRules = Yii::$container->get(EventRules::className());
        $countEventRules = count(Yii::$app->request->post($modelEventRules->formName(), []));
        $modelRules = Tools::array_pad([], $countEventRules, $modelEventRules);

        $modelEventAssignment = Yii::$container->get(EventAssignment::className());
        $countEventAssignment = count(Yii::$app->request->post($modelEventAssignment->formName(), []));
        $modelAssignment = Tools::array_pad([], $countEventAssignment, $modelEventAssignment);

        $transaction = Yii::$app->getDb()->beginTransaction();

        try {

            if ($modelNotices->load(Yii::$app->request->post()) && $modelNotices->save() &&
                $model->load(Yii::$app->request->post())
            ) {

                $model->setAttribute('notice_id',$modelNotices->notice_id);

                if ($model->save()) {

                    Model::loadMultiple($modelRules,
                        Tools::reset_keys_array(
                            Yii::$app->request->post(),
                            $modelEventRules->formName()
                        )
                    );

                    Model::loadMultiple($modelAssignment,
                        Tools::reset_keys_array(
                            Yii::$app->request->post(),
                            $modelEventAssignment->formName()
                        )
                    );

                    array_map(function (ActiveRecord $item) use ($model) {
                        $item->setAttribute('event_id', $model->event_id);
                    }, ArrayHelper::merge($modelRules, $modelAssignment));

                    if (Model::validateMultiple($modelRules) && Model::validateMultiple($modelAssignment)) {

                        foreach (ArrayHelper::merge($modelRules, $modelAssignment) as $listModel) {
                            $listModel->save(false);
                        }
                        $transaction->commit();

                        return $this->redirect(['view', 'id' => $model->event_id]);

                    }

                }

            }

        } catch (\Exception $exception) {
            $transaction->rollBack();
        }

        return $this->render('create', [
            'model' => $model,
            'modelNotices' => $modelNotices,
            'modelRules' => $modelRules,
            'modelAssignment' => $modelAssignment
        ]);
    }

    /**
     * Updates an existing Events model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelNotices = $model->notice;

        $modelEventRules = Yii::$container->get(EventRules::className());
        $countEventRules = count(Yii::$app->request->post($modelEventRules->formName(), []));
        $modelRules = Tools::array_pad($model->eventRules, $countEventRules, $modelEventRules);

        $modelEventAssignment = Yii::$container->get(EventAssignment::className());
        $countEventAssignment = count(Yii::$app->request->post($modelEventAssignment->formName(), []));
        $modelAssignment = Tools::array_pad($model->assignment, $countEventAssignment, $modelEventAssignment);

        $transaction = Yii::$app->getDb()->beginTransaction();

        try {

            if ($modelNotices->load(Yii::$app->request->post()) && $modelNotices->save() &&
                $model->load(Yii::$app->request->post()) && $model->save()
            ) {

                Model::loadMultiple($modelRules,
                    Tools::reset_keys_array(
                        Yii::$app->request->post(),
                        $modelEventRules->formName()
                    )
                );

                Model::loadMultiple($modelAssignment,
                    Tools::reset_keys_array(
                        Yii::$app->request->post(),
                        $modelEventAssignment->formName()
                    )
                );

                if (Model::validateMultiple($modelRules) && Model::validateMultiple($modelAssignment)) {

                    foreach (ArrayHelper::merge($modelRules, $modelAssignment) as $itemModel) {
                        $itemModel->save(false);
                    }

                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $model->event_id]);

                }
            }

        } catch (\Exception $exception) {
            $transaction->rollBack();
        }

        return $this->render('update', [
            'model' => $model,
            'modelNotices' => $modelNotices,
            'modelRules' => $modelRules,
            'modelAssignment' => $modelAssignment
        ]);
    }

    /**
     * Get a part for the form
     * @param $key
     * @param $modelClass
     * @param $view
     * @param null $eventId
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFields($key, $modelClass, $view, $eventId = null)
    {
        if (in_array($modelClass, [EventAssignment::className(), EventRules::className()])) {
            $model = Yii::$container->get($modelClass);
            return $this->renderPartial($view, [
                'model' => $model,
                'key' => $key,
                'eventId' => $eventId
            ]);
        } else {
            throw new NotFoundHttpException('Not found model!');
        }
    }

    /**
     * Delete relation of model
     * @param $modelClass
     * @param $relationId
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionDeleteRelation($modelClass, $relationId)
    {
        if (in_array($modelClass, [EventAssignment::className(), EventRules::className()])) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = Yii::$container->get($modelClass);
            if ($model->deleteAll([array_keys($model->getPrimaryKey(true))[0] => $relationId])) {
                $output = ['response' => 'successful'];
            } else {
                $output = ['response' => 'error'];
            }
            return $output;
        } else {
            throw new NotFoundHttpException('Not found model!');
        }
    }

    /**
     * Deletes an existing Events model.
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
     * Finds the Events model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Events the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Yii::$container->get(Events::className())->findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}