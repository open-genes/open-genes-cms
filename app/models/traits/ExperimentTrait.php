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
        $newSavedARs = [];
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
                    throw new UpdateExperimentsValidationException($id, $modelAR);
                }
            }
            foreach ($modelARs as $id => $modelAR) {
                if(!$modelAR->save()) {
                    throw new UpdateExperimentsValidationException($id, $modelAR);
                }
                if ($modelAR->isNewRecord) {
                    $modelAR->refresh();
                    $newSavedARs[$id] = $modelAR->id;
                }
            }
        } catch (Exception $e) {
            throw new UpdateExperimentsErrorException($e->getMessage());
        }
        return $newSavedARs;
    }

}