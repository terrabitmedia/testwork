<?php

namespace app\modules\events\components;


use yii\base\Object;

abstract class BaseProvider extends Object
{

    /**
     * Config container
     * @var array
     */
    public $container = [];

    /**
     * Sub configuration
     * @var array
     */
    public $config = [];

    /**
     * Key container
     * @var null
     */
    protected $keyContainer = null;

    public function init()
    {
        if (isset($this->container['class']) && !empty($this->keyContainer) &&
            !\Yii::$container->has($this->container['class'])) {
            \Yii::$container->set($this->keyContainer,$this->container);
        }
    }

}