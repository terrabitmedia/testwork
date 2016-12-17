<?php
namespace app\modules\events\components;


use yii\base\ErrorException;

class ListProviders extends BaseListPool
{
    public function getProviderInstance($class)
    {
        $object = parent::getObjectInstance($class);
        if ($object!==false) {
            if (!($object instanceof InterfaceProvider)) {
                throw new ErrorException(
                    \Yii::t('events','The class "{class}" does not support the interface InterfaceProvider',['class'=>$class])
                );
            }
        }
        return $object;
    }

    public function hasProvider($class)
    {
        return parent::hasObject($class);
    }
}