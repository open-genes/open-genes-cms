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
class LifespanExperiment extends common\LifespanExperiment
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
            [['gene_id', 'gene_intervention_id', 'intervention_result_id', 'reference'], 'required'],
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
            'intervention_result_id' => 'Результат вмешательства',
            'model_organism_id' => 'Объект',
            'age' => 'Возраст',
            'reference' => 'Ссылка',
            'age_unit' => 'Ед. измерения возраста',
        ]);
    }


    
    public function beforeValidate()
    {
        $this->lifespan_change_percent_male = str_replace(',', '.', $this->lifespan_change_percent_male);
        $this->lifespan_change_percent_female = str_replace(',', '.', $this->lifespan_change_percent_female);
        $this->lifespan_change_percent_common = str_replace(',', '.', $this->lifespan_change_percent_common);
        $this->age = str_replace(',', '.', $this->age);
        $this->reference = trim($this->reference);
        
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
        if(!empty($modelArray['gene_intervention_id']) && !is_numeric($modelArray['gene_intervention_id'])) {
            $arProteinActivityObject = GeneIntervention::createFromNameString($modelArray['gene_intervention_id']);
            $modelAR->gene_intervention_id = $arProteinActivityObject->id;
        }
        if(!empty($modelArray['model_organism_id']) && !is_numeric($modelArray['model_organism_id'])) {
            $arProcessLocalization = ModelOrganism::createFromNameString($modelArray['model_organism_id']);
            $modelAR->model_organism_id = $arProcessLocalization->id;
        }
        if(!empty($modelArray['intervention_result_id']) && !is_numeric($modelArray['intervention_result_id'])) {
            $arProteinActivity = InterventionResultForLongevity::createFromNameString($modelArray['intervention_result_id']);
            $modelAR->intervention_result_id = $arProteinActivity->id;
        }
        if(!empty($modelArray['organism_line_id']) && !is_numeric($modelArray['organism_line_id'])) {
            $arProteinActivity = OrganismLine::createFromNameString($modelArray['organism_line_id']);
            $modelAR->organism_line_id = $arProteinActivity->id;
        }
        if($modelAR->organism_line_id === '') {
            $modelAR->organism_line_id = null;
        }
        if($modelAR->genotype === '') {
            $modelAR->genotype = null;
        }
    }

}
