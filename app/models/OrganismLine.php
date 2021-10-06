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

    public static function createDuplicateLine($modelOrganismId, $organismLineId)
    {
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

    public static function fixLine($modelARC, $modelForm)
    {
        if (!empty($modelForm['model_organism_id']) && !is_numeric($modelForm['model_organism_id'])) {
            $modelARC->organism_line_id = OrganismLine::createDuplicateLine($modelARC->model_organism_id, $modelForm['organism_line_id']);
        } else {
            $currentOrganismLine = OrganismLine::getById($modelARC->organism_line_id);
            if ($currentOrganismLine->model_organism_id != $modelARC->model_organism_id) {
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

    public static function getAllNamesByOrganisms()
    {
        $names = self::find()
            ->select(['model_organism.name_ru organism_ru', 'model_organism.name_en organism_en', 'model_organism.id organism_id', 'organism_line.id', 'organism_line.name_ru', 'organism_line.name_en'])
            ->asArray()
            ->leftJoin('model_organism', 'organism_line.model_organism_id=model_organism.id')
            ->all();
        $result = [];
        foreach ($names as $name) {
            if (!$name['organism_en']) {
                $name['organism_en'] = 'other';
                $name['organism_ru'] = 'другой';
            }
            if ($name['organism_id'] !== 7) { // todo временный костыль для скрытия клеточных культур
                $result["{$name['organism_ru']} ({$name['organism_en']})"][$name['id']] = "{$name['name_ru']} ({$name['name_en']})";
            }
        }
        return $result;
    }

}
