<?php

namespace app\widgets;

use app\models\AgeRelatedChange;
use yii\base\Widget;

class AgeRelatedChangeWidget extends Widget
{
    /** @var $widgetType */
    public $widgetType = 'full';

    /** @var AgeRelatedChange */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $viewPath = $this->widgetType == 'short' ? 'short' : 'full';
        return $this->render($viewPath . '/ageRelatedChange', ['ageRelatedChange' => $this->model]);
    }
}