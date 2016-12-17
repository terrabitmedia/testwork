<?php

namespace app\modules\events\models\form;


use app\modules\events\models\ProviderHasUser;
use yii\base\Model;

class FormProviders extends Model
{
    public $providers = [];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'providers' => \Yii::t('events', 'Providers'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'providersRequired' => ['providers', 'safe'],
        ];
    }

    public function create()
    {
        $transaction = \Yii::$app->getDb()->beginTransaction();
        try {
            ProviderHasUser::deleteAll(['user_id' => \Yii::$app->getUser()->getId()]);
            foreach ((array)$this->providers as $providerId) {
                if (is_numeric($providerId) && !ProviderHasUser::addProviderToUser($providerId)) {
                    throw new \Exception('The model has not been saved!');
                }
            }
            $transaction->commit();
            return true;
        } catch (\Exception $exception) { $transaction->rollBack(); }
        return false;
    }

    public function defaultValue()
    {
        foreach (ProviderHasUser::find()->where(['user_id'=>\Yii::$app->getUser()->getId()])->all() as $item) {
            $this->providers[] = $item->provider_id;
        }
    }
}