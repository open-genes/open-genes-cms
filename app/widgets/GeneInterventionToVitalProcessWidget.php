<?php

namespace app\widgets;

use app\models\GeneInterventionToVitalProcess;
use yii\base\Widget;

class GeneInterventionToVitalProcessWidget extends Widget
{
    /** @var $widgetType */
    public $widgetType = 'full';

    /** @var GeneInterventionToVitalProcess */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $viewPath = $this->widgetType == 'short' ? 'short' : 'full';
        return $this->render($viewPath . '/geneInterventionToVitalProcess', ['geneInterventionToVitalProcess' => $this->model]);
    }
}