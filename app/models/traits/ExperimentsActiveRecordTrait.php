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
        if (isset($modelArray[$attrName]) && $modelArray[$attrName] !== '' && $modelArray[$attrName] !== null) {
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
    
    public static function createByParams($params = [])
    {
        $ar = new self();
        foreach ($params as $name => $value) {
            $ar->$name = $value;
        }
        return $ar;
    }
}