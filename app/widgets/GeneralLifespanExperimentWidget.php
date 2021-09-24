<?php

namespace app\widgets;

use app\models\GeneralLifespanExperiment;
use app\models\LifespanExperiment;
use yii\base\Widget;

class GeneralLifespanExperimentWidget extends Widget
{
    /** @var LifespanExperiment */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('generalLifespanExperiment', [
            'generalLifespanExperiment' => $this->model->generalLifespanExperiment,
            'currentGeneId' => $this->model->gene_id
        ]);
    }
}