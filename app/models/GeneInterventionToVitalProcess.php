<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\exceptions\UpdateExperimentsException;
use app\models\traits\ExperimentsActiveRecordTrait;
use app\models\traits\ValidatorsTrait;
use Yii;
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
    private $improveVitalProcessIds = [];
    private $deteriorVitalProcessIds = [];

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
            parent::rules(),
            [
                [['gene_id', 'gene_intervention_method_id', 'model_organism_id'], 'required'],
                [['age'], 'number', 'min' => 0],
                [['age_unit'], 'required', 'when' => function ($model) {
                        return !empty($model->age);
                    }],
                [['reference'], 'validateDOI'],
                [['improveVitalProcessIds', 'deteriorVitalProcessIds'], 'safe'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'delete' => 'Удалить',
                'gene_intervention_id' => 'Вмешательство',
                'model_organism_id' => 'Объект',
                'organism_line_id' => 'Линия',
                'reference' => 'Ссылка',
                'age' => 'Возраст',
                'sex_of_organism' => 'Пол',
                'age_unit' => 'Ед. изм. возраста',
            ]
        );
    }

    public function beforeValidate()
    {
        $this->age = str_replace(',', '.', $this->age);

        if (!$this->improveVitalProcessIds && !$this->deteriorVitalProcessIds) {
            $this->addError('improveVitalProcessIds', 'Пожалуйста, укажите процесс');
        }

        $ar = array_intersect($this->improveVitalProcessIds, $this->deteriorVitalProcessIds);
        if ($ar) {
            $this->addError('improveVitalProcessIds', 'Вмешательство не может улучшать и ухудшать один и тот же процесс. Пожалуйста, исправьте введенные данные');
        }

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
            if ($modelArray['delete'] === '1' && $modelAR instanceof ActiveRecord) {
                $modelAR->delete();
                continue;
            }
            $modelAR->setAttributes($modelArray);
            self::setAttributeFromNewAR($modelArray, 'gene_intervention_method_id', 'GeneInterventionMethod', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'model_organism_id', 'ModelOrganism', $modelAR);

            VitalProcess::createNewByIds($modelArray['improveVitalProcessIds']);
            VitalProcess::createNewByIds($modelArray['deteriorVitalProcessIds']);

            if (!empty($modelArray['organism_line_id']) && !is_numeric($modelArray['organism_line_id'])) {
                $arOrganismLine = OrganismLine::createFromNameString(
                    $modelArray['organism_line_id'],
                    ['model_organism_id' => $modelAR->model_organism_id]
                );
                $modelAR->organism_line_id = $arOrganismLine->id;
            } else {
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
            $message = ['subject' => ['data_for_save' => $modelArray, 'saved_ar' => $modelAR->attributes], 'message' => 'Debug Experiments Green Form'];
            \Yii::warning($message, 'experiments');
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (Yii::$app instanceof \yii\console\Application) { // todo продумать нормальный фикс
            return parent::afterSave($insert, $changedAttributes);
        }
        $this->improveVitalProcessIds = $this->getVitalProcessIdsByNames($this->improveVitalProcessIds);
        $this->deteriorVitalProcessIds = $this->getVitalProcessIdsByNames($this->deteriorVitalProcessIds);

        $this->updateRelations(
            $this->getImproveVitalProcessIds(),
            $this->improveVitalProcessIds,
            InterventionResultForVitalProcess::IMPROVEMENT_ID
        );
        $this->updateRelations(
            $this->getDeteriorVitalProcessIds(),
            $this->deteriorVitalProcessIds,
            InterventionResultForVitalProcess::DETERIORATION_ID
        );

        parent::afterSave($insert, $changedAttributes);
    }

    public function getImproveVitalProcessIds()
    {
        return GeneInterventionResultToVitalProcess::find()
            ->select('vital_process_id')
            ->where(['gene_intervention_to_vital_process_id' => $this->id, 'intervention_result_for_vital_process_id' => InterventionResultForVitalProcess::IMPROVEMENT_ID])
            ->asArray()
            ->column();
    }

    public function getDeteriorVitalProcessIds()
    {
        return GeneInterventionResultToVitalProcess::find()
            ->select('vital_process_id')
            ->where(['gene_intervention_to_vital_process_id' => $this->id, 'intervention_result_for_vital_process_id' => InterventionResultForVitalProcess::DETERIORATION_ID])
            ->asArray()
            ->column();
    }

    public function setDeteriorVitalProcessIds($ids)
    {
        if (!$ids) {
            $ids = [];
        }
        $this->deteriorVitalProcessIds = $ids;
    }

    public function setImproveVitalProcessIds($ids)
    {
        if (!$ids) {
            $ids = [];
        }
        $this->improveVitalProcessIds = $ids;
    }

    private function updateRelations($currentIdsArray, $processIdsProp, $interventionResultForVitalProcessId)
    {
        if ($currentIdsArray === $processIdsProp) {
            return;
        }
        if ($processIdsProp) {
            $relationIdsArrayToDelete = array_diff($currentIdsArray, $processIdsProp);
            $relationIdsArrayToAdd = array_diff($processIdsProp, $currentIdsArray);
            foreach ($relationIdsArrayToAdd as $relationIdArrayToAdd) {
                $geneToRelation = new GeneInterventionResultToVitalProcess();
                $geneToRelation->gene_intervention_to_vital_process_id = $this->id;
                $geneToRelation->vital_process_id = $relationIdArrayToAdd;
                $geneToRelation->intervention_result_for_vital_process_id = $interventionResultForVitalProcessId;
                $geneToRelation->save();
            }
        } else {
            $relationIdsArrayToDelete = $currentIdsArray;
        }
        $arsToDelete = GeneInterventionResultToVitalProcess::find()->where(
            [
                'and',
                ['gene_intervention_to_vital_process_id' => $this->id],
                ['intervention_result_for_vital_process_id' => $interventionResultForVitalProcessId],
                ['in', 'vital_process_id', $relationIdsArrayToDelete]
            ]
        )->all();
        foreach ($arsToDelete as $arToDelete) { // one by one for properly triggering "afterDelete" event
            $arToDelete->delete();
        }
    }

    private function getVitalProcessIdsByNames(array $arProcess) {
        foreach ($arProcess as &$process) {
            if(is_numeric($process)) {
                continue;
            }
            $process = (string)VitalProcess::getIdByName($process)->id;
        }
        return $arProcess;
    }
}
