<?php

namespace app\widgets;

use app\models\LifespanExperiment;
use yii\base\Widget;

class LifespanExperimentWidget extends Widget
{
    /** @var $type */
    public $widgetType = 'full';

    /** @var LifespanExperiment */
    public $model;
    /** @var int */
    public $currentGeneId;
    /** @var int */
    public $type = 'experiment';
    /** @var int */
    public $generalLifespanExperimentId = null;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $viewPath = $this->widgetType == 'short' ? 'short' : 'full';
        return $this->render($viewPath . '/lifespanExperiment', [
            'lifespanExperiment' => $this->model, 
            'currentGeneId' => $this->currentGeneId,
            'generalLifespanExperimentId' => $this->generalLifespanExperimentId,
            'type' => $this->type
        ]);
    }
}