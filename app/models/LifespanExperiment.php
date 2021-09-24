<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\common\GeneralLifespanExperimentQuery;
use app\models\common\LifespanExperimentQuery;
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
class LifespanExperiment extends common\LifespanExperiment
{
    use ValidatorsTrait;
    use ExperimentsActiveRecordTrait;

    public $delete = false;
    public $geneInterventionWay;
    public $tissuesIds;
    private $generalLifespanExperimentId;
    private $tissuesIdsArray;

    public function __construct($generalLifespanExperimentId = null, $config = [])
    {
        $this->generalLifespanExperimentId = $generalLifespanExperimentId;
        parent::__construct($config);
    }

    public function behaviors()
    {
        return [
            ChangelogBehavior::class
        ];
    }

    public function init()
    {
        parent::init();
        if (!$this->generalLifespanExperiment) {
            $generalLifespanExperiment = GeneralLifespanExperiment::find()->where(['id' => $this->generalLifespanExperimentId])->one();
            if (!$generalLifespanExperiment) {
                $generalLifespanExperiment = new GeneralLifespanExperiment();
                $generalLifespanExperiment->save();
                $generalLifespanExperiment->refresh();
//                $this->general_lifespan_experiment_id = $generalLifespanExperiment->id;
            }
            $this->link('generalLifespanExperiment', $generalLifespanExperiment);
            $this->populateRelation('generalLifespanExperiment', $generalLifespanExperiment);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['gene_id', 'gene_intervention_method_id'], 'required'],
            [['tissuesIds', 'geneInterventionWay', 'intervention_result_id'], 'safe'],
            [['age'], 'number', 'min' => 0],
            [['age_unit'], 'required', 'when' => function ($model) {
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

    /**
     * {@inheritdoc}
     * @return LifespanExperimentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LifespanExperimentQuery(get_called_class());
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


    /**
     * Gets query for [[GeneralLifespanExperiment]].
     *
     * @return \yii\db\ActiveQuery|GeneralLifespanExperimentQuery
     */
    public function getGeneralLifespanExperiment()
    {
        return $this->hasOne(GeneralLifespanExperiment::class, ['id' => 'general_lifespan_experiment_id']);
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
            if ($modelArray['delete'] === '1' && $modelAR instanceof ActiveRecord) {
                $modelAR->delete();
                continue;
            }
            $modelAR->setAttributes($modelArray);
            self::setAttributeFromNewAR($modelArray, 'gene_intervention_method_id', 'GeneInterventionMethod', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'active_substance_id', 'ActiveSubstance', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_period_id', 'TreatmentPeriod', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_period_id', 'TreatmentPeriod', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_start_time_unit_id', 'TreatmentTimeUnit', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_end_time_unit_id', 'TreatmentTimeUnit', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_start_stage_of_development_id', 'TreatmentStageOfDevelopment', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_end_stage_of_development_id', 'TreatmentStageOfDevelopment', $modelAR);
            $modelAR->saveTissues($modelArray['tissuesIds']);
            
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

    private function saveTissues($tissuesIdsArray)
    {
        $currentTissuesIdsArray = $this->getTissuesIdsArray();
        if ($currentTissuesIdsArray !== $tissuesIdsArray) {
            if ($tissuesIdsArray) {
                $tissuesIdsArrayToDelete = array_diff($currentTissuesIdsArray, $tissuesIdsArray);
                $tissuesIdsToAdd = array_diff($tissuesIdsArray, $currentTissuesIdsArray);
                foreach (
                    $tissuesIdsToAdd as $tissueIdToAdd) {
                    $lifespanExperimentToTissue = new LifespanExperimentToTissue();
                    $lifespanExperimentToTissue->lifespan_experiment_id = $this->id;
                    $lifespanExperimentToTissue->tissue_id = $tissueIdToAdd;
                    $lifespanExperimentToTissue->save();
                }
            } else {
                $tissuesIdsArrayToDelete = $currentTissuesIdsArray;
            }
            $arsToDelete = LifespanExperimentToTissue::find()->where(
                ['and', ['lifespan_experiment_id' => $this->id],
                    ['in', 'tissue_id', $tissuesIdsArrayToDelete]]
            )->all();
            foreach ($arsToDelete as $arToDelete) { // one by one for properly triggering "afterDelete" event
                $arToDelete->delete();
            }
        }
    }    
    
    
    private function getTissuesIdsArray()
    {
        return LifespanExperimentToTissue::find()
            ->select('tissue_id')
            ->where(['lifespan_experiment_id' => $this->id])
            ->asArray()
            ->column();
    }

    public function setTissuesIdsArray(array $ids)
    {
        $tissuesIdsArray = $ids;
    }

}
