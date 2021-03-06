<?php

namespace app\widgets;

use app\models\GeneToLongevityEffect;
use yii\base\Widget;

class GeneToLongevityEffectWidget extends Widget
{
    /** @var GeneToLongevityEffect */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('geneToLongevityEffect', ['geneToLongevityEffect' => $this->model]);
    }
}