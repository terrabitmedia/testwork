<?php

namespace app\modules\events\controllers;


use app\modules\events\models\form\FormProviders;
use yii\filters\AccessControl;
use yii\web\Controller;

class SettingsController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionProviders()
    {
        $model = new FormProviders();

        if ($model->load(\Yii::$app->getRequest()->post())) {
            if ($model->create()) {
                \Yii::$app->getSession()->addFlash('providers_saved', \Yii::t('events', 'Your choice saved.'));
            }
        } else {
            $model->defaultValue();
        }

        return $this->render('select_providers',[
            'model' => $model
        ]);
    }
}