<?php

namespace app\widgets;

use app\models\GeneToProgeria;
use yii\base\Widget;

class GeneToProgeriaWidget extends Widget
{
    /** @var $widgetType */
    public $widgetType = 'full';

    /** @var GeneToProgeria */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $viewPath = $this->widgetType == 'short' ? 'short' : 'full';
        return $this->render($viewPath . '/geneToProgeria', ['geneToProgeria' => $this->model]);
    }
}