<?php


namespace app\models\traits;


use app\models\exceptions\UpdateExperimentsException;


trait ExperimentsActiveRecordTrait
{
    /**
     * @param $modelArray
     * @param $attrName
     * @param $ARName
     * @param $currentAR
     * @throws UpdateExperimentsException
     */
    private static function setAttributeFromNewAR($modelArray, $attrName, $ARName, &$currentAR)
    {
        if (!empty($modelArray[$attrName])) {
            if (!is_numeric($modelArray[$attrName])) {
                $ar = "\app\models\\{$ARName}";
                if (!class_exists($ar)) {
                    throw new UpdateExperimentsException($modelArray['id'], $currentAR);
                }
                $setAR = $ar::createFromNameString($modelArray[$attrName]);
                $currentAR->$attrName = $setAR->id;
            }
        } else {
            $currentAR->$attrName = null;
        }
    }
}