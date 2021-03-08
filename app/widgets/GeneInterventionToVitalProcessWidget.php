<?php

namespace app\widgets;

use app\models\GeneInterventionToVitalProcess;
use yii\base\Widget;

class GeneInterventionToVitalProcessWidget extends Widget
{
    /** @var GeneInterventionToVitalProcess */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('geneInterventionToVitalProcess', ['geneInterventionToVitalProcess' => $this->model]);
    }
}