<?php
/** @var $model */
/** @var $widgetName */
/** @var $params */
use app\widgets\GeneProteinActivity;

echo $widgetName::widget(['model' => $model] + $params);