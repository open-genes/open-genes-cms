<?php

namespace cms\widgets;

use cms\models\AgeRelatedChange;
use yii\base\Widget;

class AgeRelatedChangeWidget extends Widget
{
    /** @var AgeRelatedChange */
    public $model;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('ageRelatedChange', ['ageRelatedChange' => $this->model]);
    }
}