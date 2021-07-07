<?php


namespace app\models\traits;


use app\models\exceptions\UpdateExperimentsErrorException;
use app\models\exceptions\UpdateExperimentsValidationException;
use yii\db\ActiveRecord;
use yii\db\Exception;

trait ExperimentTrait
{
    public static function saveMultipleForGene(array $modelArrays, int $geneId)
    {
        $savedARs = [];
        $erroredARs = [];
        try {
            $modelARs = []; // collect them first to validate all before saving
            foreach ($modelArrays as $id => $modelArray) {
                if(is_numeric($id)) {
                    $modelAR = self::findOne($id);
                } else {
                    $modelAR = new self();
                }
                if ($modelArray['delete'] === '1' && $modelAR instanceof ActiveRecord)  {
                    $modelAR->delete();
                    $savedARs['deleted'][$id] = $id;
                    continue;
                }
                if(!$modelAR instanceof ActiveRecord) {
                    continue;
                }
                $modelAR->setAttributes($modelArray);

                self::setExperimentValuesForGene($modelAR, $modelArray);
                $modelAR->gene_id = $geneId;

                $modelARs[$id] = $modelAR;
                if(!$modelAR->validate()) {
                    $erroredARs[$id] = $modelAR;
                }
            }
            foreach ($modelARs as $id => $ar) {
                if(!$ar->save()) {
                    $erroredARs[$id] = $ar;
                    continue;
                }
                if ($ar->id !== $id) {
                    $ar->refresh();
                    $savedARs['new'][$id] = $ar->id;
                } else {
                    $savedARs['saved'][$id] = $ar->id;
                }
            }
            if ($erroredARs) {
                throw new UpdateExperimentsValidationException($erroredARs);
            }

        } catch (Exception $e) {
            throw new UpdateExperimentsErrorException($e->getMessage());
        }
        return $savedARs;
    }

}