<?php

namespace cms\widgets;

use cms\models\GeneInterventionToVitalProcess;
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