<?php

namespace app\widgets;

use app\models\GeneToAdditionalEvidence;
use yii\base\Widget;

class AdditionalEvidencesWidget extends Widget
{
    /** @var GeneToAdditionalEvidence */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('additionalEvidences', ['geneToAdditionalEvidence' => $this->model]);
    }
}