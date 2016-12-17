<?php

namespace app\modules\news\widgets\advancedpager;


use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\LinkPager;

class AdvancedLinkPager extends LinkPager
{

    private $pageSizeList = [5, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100];

    public $pager_layout = '{pageButtons} {pageSizeList} {goToPage}';

    public $sizeListHtmlOptions = [];

    public $goToPageHtmlOptions = ['placeholder' => 'Go to page'];

    protected $_page_param = 'page';

    protected $_page_size_param = 'per-page';

    public function init()
    {
        parent::init();
        $this->_page_param = $this->pagination->pageParam;
        $this->_page_size_param = $this->pagination->pageSizeParam;
        $currentPageSize = $this->pagination->getPageSize();
        // Push current pageSize to $this->pageSizeList,
        // unique to avoid duplicating
        if ( !in_array($currentPageSize, $this->pageSizeList) ) {
            array_unshift($this->pageSizeList, $currentPageSize);
            $this->pageSizeList = array_unique($this->pageSizeList);
            // Sort
            sort($this->pageSizeList, SORT_NUMERIC);
        }
    }

    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        // Register our widget assets
        AdvancedLinkPagerAsset::register($this->getView());
        // Params will be passed to javascript
        $jsOptions = [
            'pageParam' => $this->_page_param,
            'pageSizeParam' => $this->_page_size_param,
            // Current url
            'url' => $this->pagination->createUrl($this->pagination->getPage())
        ];
        // Register inline javascript codes
        // call init method, pass params
        $this->getView()->registerJs("AdvancedLinkPager.init(" . Json::encode($jsOptions) . ");");
        return preg_replace_callback("/{(\\w+)}/", function ($matches) {
            $sub_section_name = $matches[1];
            $sub_section_content = $this->renderSection($sub_section_name);
            return $sub_section_content === false ? $matches[1] : $sub_section_content;
        }, $this->pager_layout);
    }

    protected function renderSection($name)
    {
        switch ($name) {
            case 'pageButtons':
                // Call inherited renderPageButtons() method
                return $this->renderPageButtons();
            case 'pageSizeList':
                // Render sub section, page size dropDownList
                return $this->renderPageSizeList();
            case 'goToPage':
                // Render sub section, go to page textInput
                return $this->renderGoToPage();
            default:
                return false;
        }
    }

    private function renderPageSizeList()
    {
        return Html::dropDownList($this->_page_size_param,
            $this->pagination->getPageSize(),
            array_combine($this->pageSizeList, $this->pageSizeList),
            $this->sizeListHtmlOptions
        );
    }

    private function renderGoToPage()
    {
        $current_page = 1;
        $params = Yii::$app->getRequest()->queryParams;
        if ( isset($params[$this->_page_param]) ) {
            $current_page = intval($params[$this->_page_param]);
            if ($current_page < 1) {
                $current_page = 1;
            } elseif ( $current_page > $this->pagination->getPageCount() ) {
                $current_page = $this->pagination->getPageCount();
            }
        }
        return Html::textInput($this->_page_param,
            $current_page,
            $this->goToPageHtmlOptions
        );
    }

}