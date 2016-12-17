<?php

namespace app\modules\news\widgets\advancedpager;


use yii\web\AssetBundle;

class AdvancedLinkPagerAsset extends AssetBundle
{
    public $js = [
        'js/AdvancedLinkPager.js'
    ];
    public $css = [
        /* You can add extra CSS file here if you need */
        // 'css/AdvancedLinkPager.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }
}