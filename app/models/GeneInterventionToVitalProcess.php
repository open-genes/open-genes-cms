<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\exceptions\UpdateExperimentsException;
use app\models\traits\ExperimentsActiveRecordTrait;
use app\models\traits\ValidatorsTrait;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class GeneInterventionToVitalProcess extends common\GeneInterventionToVitalProcess
{
    use ValidatorsTrait;
    use ExperimentsActiveRecordTrait;

    public $delete = false;

    public function behaviors()
    {
        return [
            ChangelogBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['gene_id', 'gene_intervention_method_id', 'model_organism_id', 'vital_process_id'], 'required'],
            [['age'], 'number', 'min'=>0],
            [['age_unit'], 'required', 'when' => function($model) {
                return !empty($model->age);
            }],
            [['reference'], 'validateDOI']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить',
            'gene_intervention_id' => 'Вмешательство',
            'vital_process_id' => 'Процесс',
            'model_organism_id' => 'Объект',
            'organism_line_id' => 'Линия',
            'reference' => 'Ссылка',
            'age' => 'Возраст',
            'sex_of_organism' => 'Пол',
            'age_unit' => 'Ед. изм. возраста',
        ]);
    }

    public function beforeValidate()
    {
        $this->age = str_replace(',', '.', $this->age);

        return parent::beforeValidate();
    }

    public static function findAllAsArray()
    {
        $result = [];
        $ages = self::find()->all();
        foreach ($ages as $age) {
            $result[$age->id] = $age->name_phylo;
        }

        return $result;
    }

    /**
     * @param array $modelArrays
     * @param int $geneId
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function saveMultipleForGene(array $modelArrays, int $geneId)
    {
        foreach ($modelArrays as $id => $modelArray) {
            if (is_numeric($id)) {
                $modelAR = self::findOne($id);
            } else {
                $modelAR = new self();
            }
            if ($modelArray['delete'] === '1' && $modelAR instanceof ActiveRecord)  {
                $modelAR->delete();
                continue;
            }
            $modelAR->setAttributes($modelArray);
            self::setAttributeFromNewAR($modelArray, 'gene_intervention_method_id', 'GeneInterventionMethod', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'model_organism_id', 'ModelOrganism', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'vital_process_id', 'VitalProcess', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'intervention_result_for_vital_process_id', 'InterventionResultForVitalProcess', $modelAR);

            if (!empty($modelArray['organism_line_id']) && !is_numeric($modelArray['organism_line_id'])) {
                $arOrganismLine = OrganismLine::createFromNameString($modelArray['organism_line_id'], ['model_organism_id' => $modelAR->model_organism_id]);
                $modelAR->organism_line_id = $arOrganismLine->id;
            }
            else {
                OrganismLine::fixLine($modelAR, $modelArray);
            }
            $modelAR->gene_id = $geneId;
            if ($modelAR->organism_line_id === '') {
                $modelAR->organism_line_id = null;
            }
            if ($modelAR->genotype === '') {
                $modelAR->genotype = null;
            }
            if (!$modelAR->validate() || !$modelAR->save()) {
                throw new UpdateExperimentsException($id, $modelAR);
            }
        }
    }

}
