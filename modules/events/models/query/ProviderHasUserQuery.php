<?php

namespace app\modules\events\models\query;

/**
 * This is the ActiveQuery class for [[\app\modules\events\models\ProviderHasUser]].
 *
 * @see \app\modules\events\models\ProviderHasUser
 */
class ProviderHasUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\events\models\ProviderHasUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\events\models\ProviderHasUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
