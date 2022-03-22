<?php

namespace app\widgets;

use app\models\ProteinToGene;
use yii\base\Widget;

class ProteinToGeneWidget extends Widget
{
    /** @var $type */
    public $widgetType = 'full';
    
    /** @var ProteinToGene */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $viewPath = $this->widgetType == 'short' ? 'short' : 'full';
        return $this->render($viewPath . '/proteinToGene', ['proteinToGene' => $this->model]);
    }
}