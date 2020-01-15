<?php

namespace cms\widgets;

use cms\models\LifespanExperiment;
use yii\base\Widget;

class LifespanExperimentWidget extends Widget
{
    /** @var LifespanExperiment */
    public $lifespanExperiment;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('lifespanExperiment', ['lifespanExperiment' => $this->lifespanExperiment]);
    }
}