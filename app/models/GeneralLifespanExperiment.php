<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\exceptions\UpdateExperimentsException;
use app\models\traits\ExperimentsActiveRecordTrait;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "general_lifespan_experiment".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $control_lifespan_min Мин. прод-ть жизни контроля
 * @property int|null $control_lifespan_mean Средняя прод-ть жизни контроля
 * @property int|null $control_lifespan_median Медиана прод-ти жизни контроля
 * @property int|null $control_lifespan_max Макс. прод-ть жизни контроля
 * @property int|null $experiment_lifespan_min Мин. прод-ть жизни эксперимента
 * @property int|null $experiment_lifespan_mean Средняя прод-ть жизни эксперимента
 * @property int|null $experiment_lifespan_median Медиана прод-ти жизни эксперимента
 * @property int|null $experiment_lifespan_max Макс. прод-ть жизни эксперимента
 * @property int|null $lifespan_min_change Мин. прод-ть жизни % изменения
 * @property int|null $lifespan_mean_change Сред. прод-ть жизни % изменения
 * @property int|null $lifespan_median_change Медиана прод-ти жизни % изменения
 * @property int|null $lifespan_max_change Макс. прод-ть жизни % изменения
 * @property int|null $control_number Количество организмов в контроле
 * @property int|null $experiment_number Количество организмов в эксперименте
 * @property int|null $expression_change Степень изменения экспрессии гена %
 * @property int|null $changed_expression_tissue_id Ткань/клетки
 * @property int|null $lifespan_change_time_unit_id
 * @property int|null $age
 * @property int|null $age_unit
 * @property int|null $intervention_result_id
 * @property int|null $lifespan_change_percent_male
 * @property int|null $lifespan_change_percent_female
 * @property int|null $lifespan_change_percent_common
 * @property int|null $lifespan_min_change_stat_sign_id
 * @property int|null $lifespan_mean_change_stat_sign_id
 * @property int|null $lifespan_median_change_stat_sign_id
 * @property int|null $lifespan_max_change_stat_sign_id
 * @property int|null $model_organism_id
 * @property int|null $organism_line_id
 * @property int|null $organism_sex_id
 * @property string|null $reference
 * @property string|null $pmid
 * @property string|null $comment_en
 * @property string|null $comment_ru
 *
 * @property Sample $changedExpressionTissue
 * @property TreatmentTimeUnit $lifespanChangeTimeUnit
 * @property StatisticalSignificance $lifespanMaxChangeStatSign
 * @property StatisticalSignificance $lifespanMeanChangeStatSign
 * @property StatisticalSignificance $lifespanMedianChangeStatSign
 * @property StatisticalSignificance $lifespanMinChangeStatSign
 * @property OrganismSex $organismSex
 * @property LifespanExperiment[] $lifespanExperiments
 */
class GeneralLifespanExperiment extends \app\models\common\GeneralLifespanExperiment
{
    use RuEnActiveRecordTrait;
    use ExperimentsActiveRecordTrait;

    public $name;
    public $delete;
    public $currentGeneId;
    private $improveVitalProcessIds = [];
    private $deteriorVitalProcessIds = [];

    /**
     * {@inheritdoc}
     */
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
//            [['model_organism_id', 'intervention_result_id'], 'required', 'on' => 'saveFromForm'], // todo OG-410
            [['delete', 'currentGeneId'], 'safe'],
            [['improveVitalProcessIds', 'deteriorVitalProcessIds'], 'safe'],
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'control_lifespan_min' => Yii::t('app', 'Мин. прод-ть жизни контроля'),
            'control_lifespan_mean' => Yii::t('app', 'Средняя прод-ть жизни контроля'),
            'control_lifespan_median' => Yii::t('app', 'Медиана прод-ти жизни контроля'),
            'control_lifespan_max' => Yii::t('app', 'Макс. прод-ть жизни контроля'),
            'experiment_lifespan_min' => Yii::t('app', 'Мин. прод-ть жизни эксперимента'),
            'experiment_lifespan_mean' => Yii::t('app', 'Средняя прод-ть жизни эксперимента'),
            'experiment_lifespan_median' => Yii::t('app', 'Медиана прод-ти жизни эксперимента'),
            'experiment_lifespan_max' => Yii::t('app', 'Макс. прод-ть жизни эксперимента'),
            'lifespan_min_change' => Yii::t('app', 'Мин. прод-ть жизни % изменения'),
            'lifespan_mean_change' => Yii::t('app', 'Сред. прод-ть жизни % изменения'),
            'lifespan_median_change' => Yii::t('app', 'Медиана прод-ти жизни % изменения'),
            'lifespan_max_change' => Yii::t('app', 'Макс. прод-ть жизни % изменения'),
            'control_number' => Yii::t('app', 'Количество организмов в контроле'),
            'experiment_number' => Yii::t('app', 'Количество организмов в эксперименте'),
            'expression_change' => Yii::t('app', 'Степень изменения экспрессии гена %'),
            'changed_expression_tissue_id' => Yii::t('app', 'Ткань/клетки'),
            'lifespan_change_time_unit_id' => Yii::t('app', 'Lifespan Change Time Unit ID'),
            'age' => Yii::t('app', 'Age'),
            'age_unit' => Yii::t('app', 'Age Unit'),
            'intervention_result_id' => Yii::t('app', 'Intervention Result ID'),
            'lifespan_change_percent_male' => Yii::t('app', 'Lifespan Change Percent Male'),
            'lifespan_change_percent_female' => Yii::t('app', 'Lifespan Change Percent Female'),
            'lifespan_change_percent_common' => Yii::t('app', 'Lifespan Change Percent Common'),
            'lifespan_min_change_stat_sign_id' => Yii::t('app', 'Lifespan Min Change Stat Sign ID'),
            'lifespan_mean_change_stat_sign_id' => Yii::t('app', 'Lifespan Mean Change Stat Sign ID'),
            'lifespan_median_change_stat_sign_id' => Yii::t('app', 'Lifespan Median Change Stat Sign ID'),
            'lifespan_max_change_stat_sign_id' => Yii::t('app', 'Lifespan Max Change Stat Sign ID'),
            'model_organism_id' => Yii::t('app', 'Model Organism ID'),
            'organism_line_id' => Yii::t('app', 'Organism Line ID'),
            'organism_sex_id' => Yii::t('app', 'Organism Sex ID'),
            'reference' => Yii::t('app', 'Reference'),
            'pmid' => Yii::t('app', 'Pmid'),
            'comment_en' => Yii::t('app', 'Comment En'),
            'comment_ru' => Yii::t('app', 'Comment Ru'),
        ];
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
        $this->reference = trim($this->reference);

        $ar = array_intersect($this->improveVitalProcessIds, $this->deteriorVitalProcessIds);
        if ($ar) {
            $this->addError('improveVitalProcessIds', 'Вмешательство не может улучшать и ухудшать один и тот же процесс. Пожалуйста, исправьте введенные данные');
        }
        return parent::beforeValidate();
    }

    /**
     * Gets query for [[ChangedExpressionTissue]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\SampleQuery
     */
    public function getChangedExpressionTissue()
    {
        return $this->hasOne(Sample::class, ['id' => 'changed_expression_tissue_id']);
    }

    /**
     * Gets query for [[LifespanChangeTimeUnit]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\TreatmentTimeUnitQuery
     */
    public function getLifespanChangeTimeUnit()
    {
        return $this->hasOne(TreatmentTimeUnit::class, ['id' => 'lifespan_change_time_unit_id']);
    }

    /**
     * Gets query for [[LifespanMaxChangeStatSign]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\StatisticalSignificanceQuery
     */
    public function getLifespanMaxChangeStatSign()
    {
        return $this->hasOne(StatisticalSignificance::class, ['id' => 'lifespan_max_change_stat_sign_id']);
    }

    /**
     * Gets query for [[LifespanMeanChangeStatSign]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\StatisticalSignificanceQuery
     */
    public function getLifespanMeanChangeStatSign()
    {
        return $this->hasOne(StatisticalSignificance::class, ['id' => 'lifespan_mean_change_stat_sign_id']);
    }

    /**
     * Gets query for [[LifespanMedianChangeStatSign]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\StatisticalSignificanceQuery
     */
    public function getLifespanMedianChangeStatSign()
    {
        return $this->hasOne(StatisticalSignificance::class, ['id' => 'lifespan_median_change_stat_sign_id']);
    }

    /**
     * Gets query for [[LifespanMinChangeStatSign]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\StatisticalSignificanceQuery
     */
    public function getLifespanMinChangeStatSign()
    {
        return $this->hasOne(StatisticalSignificance::class, ['id' => 'lifespan_min_change_stat_sign_id']);
    }

    /**
     * Gets query for [[OrganismSex]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\OrganismSexQuery
     */
    public function getOrganismSex()
    {
        return $this->hasOne(OrganismSex::class, ['id' => 'organism_sex_id']);
    }

    /**
     * @param $type
     * @return LifespanExperiment[]
     */
    public function getLifespanExperimentsForForm($type): array
    {
        return LifespanExperiment::find()
            ->where([
                'general_lifespan_experiment_id' => $this->id,
                'type' => $type
            ])
            ->all();
    }
    

    /**
     * Gets query for [[LifespanExperiments]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::class, ['general_lifespan_experiment_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

    /**
     * @param int|string $id
     * @param array $modelArray
     * @throws UpdateExperimentsException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function saveFromExperiments($id, array $modelArray)
    {
        if (is_numeric($id)) {
            $modelAR = self::findOne($id);
        } else {
            $modelAR = new self();
        }
        try {
            if ($modelArray['delete'] === '1' && $modelAR instanceof ActiveRecord) {
                $arsToDelete = LifespanExperiment::find()->where(
                    [
                        'general_lifespan_experiment_id' => $modelAR->id,
                        'gene_id' => $modelArray['currentGeneId']
                    ]
                )->all();
                foreach ($arsToDelete as $arToDelete) { // one by one for properly triggering "afterDelete" event
                    $arToDelete->delete();
                }
            }
            if(!$modelAR->lifespanExperiments) {
                $modelAR->delete();
                return;
            }
        } catch (Exception $e) {
            throw new UpdateExperimentsException($id, $modelAR);
        }
//        $modelAR->setScenario('saveFromForm');
        $modelAR->setAttributes($modelArray);
        self::setAttributeFromNewAR($modelArray, 'model_organism_id', 'ModelOrganism', $modelAR);
        self::setAttributeFromNewAR($modelArray, 'intervention_result_id', 'InterventionResultForLongevity', $modelAR);
        self::setAttributeFromNewAR($modelArray, 'organism_sex_id', 'OrganismSex', $modelAR);
        self::setAttributeFromNewAR($modelArray, 'changed_expression_tissue_id', 'Sample', $modelAR);
        self::setAttributeFromNewAR($modelArray, 'lifespan_change_time_unit_id', 'TreatmentTimeUnit', $modelAR);
        self::setAttributeFromNewAR($modelArray, 'lifespan_change_time_unit_id', 'TreatmentTimeUnit', $modelAR);

        VitalProcess::createNewByIds($modelArray['improveVitalProcessIds']);
        VitalProcess::createNewByIds($modelArray['deteriorVitalProcessIds']);

        if(!empty($modelArray['organism_line_id']) && !is_numeric($modelArray['organism_line_id'])) {
            $arProteinActivity = OrganismLine::createFromNameString($modelArray['organism_line_id'], ['model_organism_id' => $modelAR->model_organism_id]);
            $modelAR->organism_line_id = $arProteinActivity->id;
        } else {
            OrganismLine::fixLine($modelAR, $modelArray);
        }
        
        if (!$modelAR->validate() || !$modelAR->save()) {
            throw new UpdateExperimentsException($id, $modelAR);
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
        return GeneralLifespanExperimentToVitalProcess::find()
            ->select('vital_process_id')
            ->where(['general_lifespan_experiment_id' => $this->id, 'intervention_result_for_vital_process_id' => InterventionResultForVitalProcess::IMPROVEMENT_ID])
            ->asArray()
            ->column();
    }

    public function getDeteriorVitalProcessIds()
    {
        return GeneralLifespanExperimentToVitalProcess::find()
            ->select('vital_process_id')
            ->where(['general_lifespan_experiment_id' => $this->id, 'intervention_result_for_vital_process_id' => InterventionResultForVitalProcess::DETERIORATION_ID])
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
                $geneToRelation = new GeneralLifespanExperimentToVitalProcess();
                $geneToRelation->general_lifespan_experiment_id = $this->id;
                $geneToRelation->vital_process_id = $relationIdArrayToAdd;
                $geneToRelation->intervention_result_for_vital_process_id = $interventionResultForVitalProcessId;
                $geneToRelation->save();
            }
        } else {
            $relationIdsArrayToDelete = $currentIdsArray;
        }
        $arsToDelete = GeneralLifespanExperimentToVitalProcess::find()->where(
            [
                'and',
                ['general_lifespan_experiment_id' => $this->id],
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
