<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "general_lifespan_experiment".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $control_lifespan_min Мин. прод-ть жизни контроля
 * @property float|null $control_lifespan_mean Сред. прод-ть жизни контроля
 * @property float|null $control_lifespan_median Мед. прод-ть жизни контроля
 * @property float|null $control_lifespan_max Макс. прод-ть жизни контроля
 * @property float|null $experiment_lifespan_min Мин. прод-ть жизни эксперимента
 * @property float|null $experiment_lifespan_mean Сред. прод-ть жизни эксперимента
 * @property float|null $experiment_lifespan_median Мед. прод-ть жизни эксперимента
 * @property float|null $experiment_lifespan_max Макс. прод-ть жизни эксперимента
 * @property float|null $lifespan_min_change Мин. прод-ть жизни % изменения
 * @property float|null $lifespan_mean_change Сред. прод-ть жизни % изменения
 * @property float|null $lifespan_median_change Мед. прод-ть жизни % изменения
 * @property float|null $lifespan_max_change Макс. прод-ть жизни % изменения
 * @property int|null $control_number Количество организмов в контроле
 * @property int|null $experiment_number Количество организмов в эксперименте
 * @property float|null $expression_change Степень изменения экспрессии гена %
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
 * @property int|null $measurement_type
 *
 * @property Sample $changedExpressionTissue
 * @property TreatmentTimeUnit $lifespanChangeTimeUnit
 * @property StatisticalSignificance $lifespanMaxChangeStatSign
 * @property StatisticalSignificance $lifespanMeanChangeStatSign
 * @property StatisticalSignificance $lifespanMedianChangeStatSign
 * @property StatisticalSignificance $lifespanMinChangeStatSign
 * @property OrganismSex $organismSex
 * @property GeneralLifespanExperimentToStrain[] $generalLifespanExperimentToStrains
 * @property LifespanExperiment[] $lifespanExperiments
 */
class GeneralLifespanExperiment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'general_lifespan_experiment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['control_lifespan_min', 'control_lifespan_mean', 'control_lifespan_median', 'control_lifespan_max', 'experiment_lifespan_min', 'experiment_lifespan_mean', 'experiment_lifespan_median', 'experiment_lifespan_max', 'lifespan_min_change', 'lifespan_mean_change', 'lifespan_median_change', 'lifespan_max_change', 'expression_change'], 'number'],
            [['control_number', 'experiment_number', 'changed_expression_tissue_id', 'lifespan_change_time_unit_id', 'age', 'age_unit', 'intervention_result_id', 'lifespan_change_percent_male', 'lifespan_change_percent_female', 'lifespan_change_percent_common', 'lifespan_min_change_stat_sign_id', 'lifespan_mean_change_stat_sign_id', 'lifespan_median_change_stat_sign_id', 'lifespan_max_change_stat_sign_id', 'model_organism_id', 'organism_line_id', 'organism_sex_id', 'measurement_type'], 'integer'],
            [['comment_en', 'comment_ru'], 'string'],
            [['name', 'reference', 'pmid'], 'string', 'max' => 255],
            [['changed_expression_tissue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::class, 'targetAttribute' => ['changed_expression_tissue_id' => 'id']],
            [['lifespan_change_time_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => TreatmentTimeUnit::class, 'targetAttribute' => ['lifespan_change_time_unit_id' => 'id']],
            [['lifespan_max_change_stat_sign_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatisticalSignificance::class, 'targetAttribute' => ['lifespan_max_change_stat_sign_id' => 'id']],
            [['lifespan_mean_change_stat_sign_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatisticalSignificance::class, 'targetAttribute' => ['lifespan_mean_change_stat_sign_id' => 'id']],
            [['lifespan_median_change_stat_sign_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatisticalSignificance::class, 'targetAttribute' => ['lifespan_median_change_stat_sign_id' => 'id']],
            [['lifespan_min_change_stat_sign_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatisticalSignificance::class, 'targetAttribute' => ['lifespan_min_change_stat_sign_id' => 'id']],
            [['organism_sex_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismSex::class, 'targetAttribute' => ['organism_sex_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'control_lifespan_min' => Yii::t('app', 'Control Lifespan Min'),
            'control_lifespan_mean' => Yii::t('app', 'Control Lifespan Mean'),
            'control_lifespan_median' => Yii::t('app', 'Control Lifespan Median'),
            'control_lifespan_max' => Yii::t('app', 'Control Lifespan Max'),
            'experiment_lifespan_min' => Yii::t('app', 'Experiment Lifespan Min'),
            'experiment_lifespan_mean' => Yii::t('app', 'Experiment Lifespan Mean'),
            'experiment_lifespan_median' => Yii::t('app', 'Experiment Lifespan Median'),
            'experiment_lifespan_max' => Yii::t('app', 'Experiment Lifespan Max'),
            'lifespan_min_change' => Yii::t('app', 'Lifespan Min Change'),
            'lifespan_mean_change' => Yii::t('app', 'Lifespan Mean Change'),
            'lifespan_median_change' => Yii::t('app', 'Lifespan Median Change'),
            'lifespan_max_change' => Yii::t('app', 'Lifespan Max Change'),
            'control_number' => Yii::t('app', 'Control Number'),
            'experiment_number' => Yii::t('app', 'Experiment Number'),
            'expression_change' => Yii::t('app', 'Expression Change'),
            'changed_expression_tissue_id' => Yii::t('app', 'Changed Expression Tissue ID'),
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
            'measurement_type' => Yii::t('app', 'Measurement Type'),
        ];
    }

    /**
     * Gets query for [[ChangedExpressionTissue]].
     *
     * @return \yii\db\ActiveQuery|SampleQuery
     */
    public function getChangedExpressionTissue()
    {
        return $this->hasOne(Sample::class, ['id' => 'changed_expression_tissue_id']);
    }

    /**
     * Gets query for [[LifespanChangeTimeUnit]].
     *
     * @return \yii\db\ActiveQuery|TreatmentTimeUnitQuery
     */
    public function getLifespanChangeTimeUnit()
    {
        return $this->hasOne(TreatmentTimeUnit::class, ['id' => 'lifespan_change_time_unit_id']);
    }

    /**
     * Gets query for [[LifespanMaxChangeStatSign]].
     *
     * @return \yii\db\ActiveQuery|StatisticalSignificanceQuery
     */
    public function getLifespanMaxChangeStatSign()
    {
        return $this->hasOne(StatisticalSignificance::class, ['id' => 'lifespan_max_change_stat_sign_id']);
    }

    /**
     * Gets query for [[LifespanMeanChangeStatSign]].
     *
     * @return \yii\db\ActiveQuery|StatisticalSignificanceQuery
     */
    public function getLifespanMeanChangeStatSign()
    {
        return $this->hasOne(StatisticalSignificance::class, ['id' => 'lifespan_mean_change_stat_sign_id']);
    }

    /**
     * Gets query for [[LifespanMedianChangeStatSign]].
     *
     * @return \yii\db\ActiveQuery|StatisticalSignificanceQuery
     */
    public function getLifespanMedianChangeStatSign()
    {
        return $this->hasOne(StatisticalSignificance::class, ['id' => 'lifespan_median_change_stat_sign_id']);
    }

    /**
     * Gets query for [[LifespanMinChangeStatSign]].
     *
     * @return \yii\db\ActiveQuery|StatisticalSignificanceQuery
     */
    public function getLifespanMinChangeStatSign()
    {
        return $this->hasOne(StatisticalSignificance::class, ['id' => 'lifespan_min_change_stat_sign_id']);
    }

    /**
     * Gets query for [[OrganismSex]].
     *
     * @return \yii\db\ActiveQuery|OrganismSexQuery
     */
    public function getOrganismSex()
    {
        return $this->hasOne(OrganismSex::class, ['id' => 'organism_sex_id']);
    }

    /**
     * Gets query for [[GeneralLifespanExperimentToStrains]].
     *
     * @return \yii\db\ActiveQuery|GeneralLifespanExperimentToStrainQuery
     */
    public function getGeneralLifespanExperimentToStrains()
    {
        return $this->hasMany(GeneralLifespanExperimentToStrain::class, ['general_lifespan_experiment_id' => 'id']);
    }

    /**
     * Gets query for [[LifespanExperiments]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::class, ['general_lifespan_experiment_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneralLifespanExperimentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneralLifespanExperimentQuery(get_called_class());
    }
}
