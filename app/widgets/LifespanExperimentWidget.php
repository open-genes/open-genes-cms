<?php

namespace app\widgets;

use app\models\LifespanExperiment;
use yii\base\Widget;

class LifespanExperimentWidget extends Widget
{
    /** @var LifespanExperiment */
    public $model;
    /** @var int */
    public $currentGeneId;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('lifespanExperiment', ['lifespanExperiment' => $this->model, 'currentGeneId' => $this->currentGeneId]);
    }
}