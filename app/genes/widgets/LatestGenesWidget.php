<?php

namespace genes\widgets;

use yii\base\Widget;

class LatestGenesWidget extends Widget
{
    public $geneDtos;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('latestGenesWidgetView', ['geneDtos' => $this->geneDtos]);
    }
}