<?php


namespace app\models\traits;


use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

trait ExperimentsActiveRecordTrait
{

    private static function setAttributeFromNewAR($attrName, $ARName, &$currentAR)
    {
        if (!empty($modelArray[$attrName])) {
            if(!is_numeric($modelArray[$attrName])) {
                $setAR = $ARName::createFromNameString($modelArray[$attrName]);
                $currentAR->$attrName = $setAR->id;
            }
        } else {
            $currentAR->$attrName = null;
        }
    }
}