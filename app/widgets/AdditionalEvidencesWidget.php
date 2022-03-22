<?php

namespace app\widgets;

use app\models\GeneToAdditionalEvidence;
use yii\base\Widget;

class AdditionalEvidencesWidget extends Widget
{
    /** @var $widgetType */
    public $widgetType = 'full';
    
    /** @var GeneToAdditionalEvidence */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $viewPath = $this->widgetType == 'short' ? 'short' : 'full';
        return $this->render($viewPath . '/additionalEvidences', ['geneToAdditionalEvidence' => $this->model]);
    }
}