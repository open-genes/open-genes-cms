<?php

namespace app\widgets;

use app\models\GeneralLifespanExperiment;
use app\models\LifespanExperiment;
use yii\base\Widget;

class GeneralLifespanExperimentWidget extends Widget
{
    /** @var $widgetType */
    public $widgetType = 'full';

    /** @var LifespanExperiment */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if($this->model->generalLifespanExperiment) {
            $viewPath = $this->widgetType == 'short' ? 'short' : 'full';
            return $this->render($viewPath . '/generalLifespanExperiment', [
                'generalLifespanExperiment' => $this->model->generalLifespanExperiment,
                'currentLifespanExperiment' => $this->model,
                'currentGeneId' => $this->model->gene_id
            ]);
        }
        return false;
    }
}