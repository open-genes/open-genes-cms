<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\ConditionActiveRecordTrait;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "organism_line".
 *
 */
class OrganismLine extends common\OrganismLine
{
    use RuEnActiveRecordTrait;
    use ConditionActiveRecordTrait;

    public $name;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }

    public function getLinkedGenesIds()
    {
        return array_unique(array_merge(
            $this->getLifespanExperiments()
                ->select('gene_id')->distinct()->column(),
            $this->getGeneInterventionToVitalProcesses()
                ->select('gene_id')->distinct()->column(),
            $this->getAgeRelatedChanges()
                ->select('gene_id')->distinct()->column()
        ));
    }

    public static function createDuplicateLine($modelOrganismId, $organismLineId) {
        $model = self::getById($organismLineId);
        $dataToInsert = $model->attributes;
        unset($dataToInsert['id']);
        $dataToInsert['model_organism_id'] = $modelOrganismId;
        $model = new self();
        foreach ($dataToInsert as $col => $row) {
            $model->$col = $row;
        }
        $model->save();
        return $model->id;
    }

    public static function getById($id)
    {
        return self::find()->where(['id' => $id])->one();
    }

    public static function fixLine($modelARC, $modelForm) {
        if (!empty($modelForm['model_organism_id']) && !is_numeric($modelForm['model_organism_id'])) {
            $modelARC->organism_line_id = OrganismLine::createDuplicateLine($modelARC->model_organism_id, $modelForm['organism_line_id']);
        }
        else {
            $currentOrganismLine = OrganismLine::getById($modelARC->organism_line_id);
            if($currentOrganismLine->model_organism_id != $modelARC->model_organism_id) {
                $modelARC->organism_line_id = self::getRightLineID($currentOrganismLine, $modelARC);
            }
        }
    }

    private static function getRightLineID($currentOrganismLine, $modelARC)
    {
        $rightOrganismLine = OrganismLine::find()->where(
            ['name_ru' => $currentOrganismLine->name_ru, 'model_organism_id' => $modelARC->model_organism_id])->one();
        if ($rightOrganismLine) {
            return $rightOrganismLine->id;
        }
        return OrganismLine::createDuplicateLine($modelARC->model_organism_id, $currentOrganismLine->id);
    }

}
