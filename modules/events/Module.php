<?php

namespace app\modules\events;


use yii\helpers\FileHelper;

class Module extends \yii\base\Module
{
    public $root = '@app';

    public $patterns = [
        '/modules/*/models/*.php'
    ];

    public $tmpDir = '@runtime';

    public $typeModels = '\yii\db\ActiveRecord';

    public $scanTimeLimit = 600;

    public $sender = null;

    public $listenEvents = [
        'beforeUpdate',
        'afterUpdate',
        'beforeInsert',
        'afterInsert',
        'beforeDelete',
        'afterDelete'
    ];

    public $eventPriority = true;

    public $subDataInEvent = null;

    public $pathRule = '@app/modules/events/components/rules';

    public $pathNotices = '@app/modules/events/components/notices';

    public $modelMap = [
        'Events' => 'app\modules\events\models\Events',
        'EventRules' => 'app\modules\events\models\EventRules',
        'EventProviders' => 'app\modules\events\models\EventProviders',
        'EventNotices' => 'app\modules\events\models\EventNotices',
        'EventAssignment' => 'app\modules\events\models\EventAssignment',
        'Messages' => 'app\modules\events\models\Messages',
        'Prepared' => 'app\modules\events\models\Prepared',
        'ProviderHasUser' => 'app\modules\events\models\ProviderHasUser'
    ];

    public function getAliasOfFiles($root,$patterns=['*.php'])
    {
        $closureAlias = function($path) {
            return 'app'.str_replace([\Yii::getAlias($this->root),DIRECTORY_SEPARATOR,'.php'],['','\\',''],$path);
        };
        $closureAlias->bindTo($this);
        return array_map($closureAlias,FileHelper::findFiles(\Yii::getAlias($root),['only' => $patterns]));
    }

    public function scanAllModels()
    {
        $files = [];

        foreach ($this->getAliasOfFiles($this->root,$this->patterns) as $alias) {
            $reflectionClass = new \ReflectionClass($alias);
            if ($reflectionClass->isSubclassOf($this->typeModels)) {
                $files[] = $reflectionClass->getName();
            }
        }

        return $files;

    }

}