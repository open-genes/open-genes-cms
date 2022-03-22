<?php

namespace app\widgets;

use app\models\GeneToLongevityEffect;
use yii\base\Widget;

class GeneToLongevityEffectWidget extends Widget
{
    /** @var $type */
    public $widgetType = 'full';

    /** @var GeneToLongevityEffect */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $viewPath = $this->widgetType == 'short' ? 'short' : 'full';
        return $this->render($viewPath . '/geneToLongevityEffect', ['geneToLongevityEffect' => $this->model]);
    }
}