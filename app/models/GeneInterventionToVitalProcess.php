<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\exceptions\UpdateExperimentsValidationException;
use app\models\traits\ExperimentTrait;
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
    use ExperimentTrait;

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
            [['gene_id', 'gene_intervention_id', 'model_organism_id', 'vital_process_id', 'reference'], 'required'],
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

    private static function setExperimentValuesForGene(&$modelAR, $modelArray)
    {
        if (!empty($modelArray['model_organism_id']) && !is_numeric($modelArray['model_organism_id'])) {
            $arProcessLocalization = ModelOrganism::createFromNameString($modelArray['model_organism_id']);
            $modelAR->model_organism_id = $arProcessLocalization->id;
        }
        if (!empty($modelArray['gene_intervention_id']) && !is_numeric($modelArray['gene_intervention_id'])) {
            $arProteinActivityObject = GeneIntervention::createFromNameString($modelArray['gene_intervention_id']);
            $modelAR->gene_intervention_id = $arProteinActivityObject->id;
        }
        if (!empty($modelArray['vital_process_id']) && !is_numeric($modelArray['vital_process_id'])) {
            $arVitalProcess = VitalProcess::createFromNameString($modelArray['vital_process_id']);
            $modelAR->vital_process_id = $arVitalProcess->id;
        }
        if (!empty($modelArray['organism_line_id']) && !is_numeric($modelArray['organism_line_id'])) {
            $arOrganismLine = OrganismLine::createFromNameString($modelArray['organism_line_id']);
            $modelAR->organism_line_id = $arOrganismLine->id;
        }
        if (!empty($modelArray['intervention_result_for_vital_process_id']) && !is_numeric($modelArray['intervention_result_for_vital_process_id'])) {
            $arOrganismLine = InterventionResultForVitalProcess::createFromNameString($modelArray['intervention_result_for_vital_process_id']);
            $modelAR->intervention_result_for_vital_process_id = $arOrganismLine->id;
        }
        if ($modelAR->organism_line_id == '') {
            $modelAR->organism_line_id = null;
        }
        if ($modelAR->genotype === '') {
            $modelAR->genotype = null;
        }
    }

}
