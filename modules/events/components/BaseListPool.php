<?php

namespace app\modules\events\components;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

abstract class BaseListPool
{

    private $_instance = [];

    private $_configList = [];

    /**
     * Construct class
     * @param $config
     */
    public function __construct($config)
    {
        foreach ($config as $item) {
            if (isset($item['class'],$item['data'])) {
                $this->_configList[$item['class']] = $item['data'];
            }
        }
    }

    /**
     * Get a instance object
     * @param $class
     * @return bool|mixed
     */
    protected function getObjectInstance($class)
    {
        if ($this->hasObject($class)) {
            if (isset($this->_instance[$class])) {
                return $this->_instance[$class];
            }
            $this->_instance[$class] = \Yii::createObject(
                ArrayHelper::merge(
                    ['class' => $class],
                    Json::decode($this->_configList[$class])
                )
            );
            return $this->_instance[$class];
        }
        return false;
    }

    /**
     * Has a object
     * @param $class
     * @return bool
     */
    protected function hasObject($class)
    {
        return isset($this->_configList[$class]) || isset($this->_instance[$class]);
    }

}