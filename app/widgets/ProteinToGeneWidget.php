<?php

namespace app\widgets;

use app\models\ProteinToGene;
use yii\base\Widget;

class ProteinToGeneWidget extends Widget
{
    /** @var ProteinToGene */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('proteinToGene', ['proteinToGene' => $this->model]);
    }
}