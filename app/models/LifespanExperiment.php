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
    public $tissuesIds;
    private $tissuesIdsArray;

    public function behaviors()
    {
        return [
            ChangelogBehavior::class
        ];
    }

    public static function createByParams($params = [])
    {
        $ar = new self();
        foreach ($params as $name => $value) {
            $ar->$name = $value;
        }
        if (!$ar->general_lifespan_experiment_id) {
            $generalLifespanExperiment = new GeneralLifespanExperiment();
            $generalLifespanExperiment->save();
            $generalLifespanExperiment->refresh();
            $ar->general_lifespan_experiment_id = $generalLifespanExperiment->id;
            $ar->link('generalLifespanExperiment', $generalLifespanExperiment);
            $ar->populateRelation('generalLifespanExperiment', $generalLifespanExperiment);
            $ar->save();
        }
        return $ar;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['gene_id', 'gene_intervention_method_id'], 'safe'], // todo OG-410
            [['tissuesIds'], 'safe'],
            [['age'], 'number', 'min' => 0],
            [['reference'], 'validateDOI']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить',
            'gene_intervention_id' => 'Вмешательство',
            'tissue_specificity' => 'Тканеспецифичность',
            'mutation_induction' => 'Индукция мутации отменой препарата',
            'tissue_specific_promoter' => 'Тканеспецифичный промотер',
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

    /**
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeValidate()
    {
        foreach ($this->getTableSchema()->columns as $column) {
            if ($column->type == 'float') {
                $attr = $column->name;
                $this->$attr = trim(str_replace(',', '.', $this->$attr));
            }
        }
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
    
    public function beforeDelete()
    {
        $tissues = LifespanExperimentToTissue::find()->where(
            ['lifespan_experiment_id' => $this->id]
        )->all();
        foreach ($tissues as $arToDelete) { // one by one for properly triggering "afterDelete" event
            $arToDelete->delete();
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    /**
     * @param array $modelArrays
     * @param int $geneId
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function saveMultipleForGene(array $modelArrays)
    {
        foreach ($modelArrays as $id => $modelArray) {
            if (is_numeric($id)) {
                $modelAR = self::findOne($id);
                if (!$modelAR) {
                    continue;
                }
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
            self::setAttributeFromNewAR($modelArray, 'active_substance_delivery_way_id', 'ActiveSubstanceDeliveryWay', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_period_id', 'TreatmentPeriod', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_period_id', 'TreatmentPeriod', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_start_time_unit_id', 'TreatmentTimeUnit', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_end_time_unit_id', 'TreatmentTimeUnit', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_start_stage_of_development_id', 'TreatmentStageOfDevelopment', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'treatment_end_stage_of_development_id', 'TreatmentStageOfDevelopment', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'genotype', 'Genotype', $modelAR);

            if ($modelAR->organism_line_id === '') {
                $modelAR->organism_line_id = null;
            }
            if ($modelAR->genotype === '') {
                $modelAR->genotype = null;
            }
            if (!$modelAR->validate() || !$modelAR->save()) {
                throw new UpdateExperimentsException($id, $modelAR);
            }
            $modelAR->saveTissues($modelArray['tissuesIdsArray']);
        }
    }

    private function saveTissues($tissuesIdsArray)
    {
        $currentTissuesIdsArray = $this->getTissuesIdsArray();

        if ($currentTissuesIdsArray !== $tissuesIdsArray) {
            if ($tissuesIdsArray) {
                $tissuesIdsArrayToDelete = array_diff($currentTissuesIdsArray, $tissuesIdsArray);
                $tissuesIdsToAdd = array_diff($tissuesIdsArray, $currentTissuesIdsArray);

                foreach ($tissuesIdsToAdd as $tissueIdToAdd) {
                    if (!is_numeric($tissueIdToAdd)) {
                        $tissueToAdd = Sample::createFromNameString($tissueIdToAdd);
                        $tissueIdToAdd = $tissueToAdd->id;
                    }
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


    public function getTissuesIdsArray()
    {
        return LifespanExperimentToTissue::find()
            ->select('tissue_id')
            ->where(['lifespan_experiment_id' => $this->id])
            ->asArray()
            ->column();
    }

    public function setTissuesIdsArray(array $ids)
    {
        $this->tissuesIdsArray = $ids;
    }

}
