<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "lifespan_experiment".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $gene_intervention_id
 * @property int|null $intervention_result_id
 * @property int|null $model_organism_id
 * @property float|null $age
 * @property string|null $reference
 * @property string|null $comment_en
 * @property string|null $comment_ru
 * @property int|null $sex
 * @property int|null $organism_line_id
 * @property float|null $lifespan_change_percent_male
 * @property float|null $lifespan_change_percent_female
 * @property float|null $lifespan_change_percent_common
 * @property int|null $age_unit
 * @property int|null $genotype
 * @property string|null $pmid
 * @property int|null $tissue_specificity Тканеспецифичность
 * @property int|null $active_substance_daily_dose Дневная доза
 * @property int|null $active_substance_daily_doses_number Количество воздействий в день
 * @property int|null $treatment_start Начало периода воздействия
 * @property int|null $treatment_end Конец периода воздействия
 * @property int|null $control_number Количество организмов в контроле
 * @property int|null $experiment_number Количество организмов в эксперименте
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
 * @property int|null $active_substance_id
 * @property int|null $active_substance_delivery_way_id
 * @property int|null $active_substance_dosage_unit_id
 * @property int|null $treatment_period_id
 * @property int|null $gene_intervention_method_id
 * @property int|null $experiment_main_effect_id
 * @property int|null $organism_sex_id
 * @property int|null $treatment_start_stage_of_development_id
 * @property int|null $treatment_end_stage_of_development_id
 * @property int|null $treatment_start_time_unit_id
 * @property int|null $treatment_end_time_unit_id
 * @property int|null $lifespan_min_change_stat_sign_id
 * @property int|null $lifespan_mean_change_stat_sign_id
 * @property int|null $lifespan_median_change_stat_sign_id
 * @property int|null $lifespan_max_change_stat_sign_id
 *
 * @property ActiveSubstance $activeSubstance
 * @property ActiveSubstanceDeliveryWay $activeSubstanceDeliveryWay
 * @property ActiveSubstanceDosageUnit $activeSubstanceDosageUnit
 * @property TreatmentTimeUnit $treatmentEndTimeUnit
 * @property ExperimentMainEffect $experimentMainEffect
 * @property ExperimentTreatmentPeriod $treatmentPeriod
 * @property Gene $gene
 * @property GeneIntervention $geneIntervention
 * @property GeneInterventionMethod $geneInterventionMethod
 * @property InterventionResultForLongevity $interventionResult
 * @property StatisticalSignificance $lifespanMaxChangeStatSign
 * @property StatisticalSignificance $lifespanMeanChangeStatSign
 * @property StatisticalSignificance $lifespanMedianChangeStatSign
 * @property StatisticalSignificance $lifespanMinChangeStatSign
 * @property ModelOrganism $modelOrganism
 * @property OrganismLine $organismLine
 * @property OrganismSex $organismSex
 * @property TreatmentTimeUnit $treatmentStartTimeUnit
 * @property TreatmentStageOfDevelopment $treatmentEndStageOfDevelopment
 * @property TreatmentStageOfDevelopment $treatmentStartStageOfDevelopment
 * @property LifespanExperimentLink[] $lifespanExperimentLinks
 * @property LifespanExperimentLink[] $lifespanExperimentLinks0
 * @property LifespanExperimentToTissue[] $lifespanExperimentToTissues
 */
class LifespanExperiment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lifespan_experiment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'gene_intervention_id', 'intervention_result_id', 'model_organism_id', 'sex', 'organism_line_id', 'age_unit', 'genotype', 'tissue_specificity', 'active_substance_daily_dose', 'active_substance_daily_doses_number', 'treatment_start', 'treatment_end', 'control_number', 'experiment_number', 'control_lifespan_min', 'control_lifespan_mean', 'control_lifespan_median', 'control_lifespan_max', 'experiment_lifespan_min', 'experiment_lifespan_mean', 'experiment_lifespan_median', 'experiment_lifespan_max', 'lifespan_min_change', 'lifespan_mean_change', 'lifespan_median_change', 'lifespan_max_change', 'active_substance_id', 'active_substance_delivery_way_id', 'active_substance_dosage_unit_id', 'treatment_period_id', 'gene_intervention_method_id', 'experiment_main_effect_id', 'organism_sex_id', 'treatment_start_stage_of_development_id', 'treatment_end_stage_of_development_id', 'treatment_start_time_unit_id', 'treatment_end_time_unit_id', 'lifespan_min_change_stat_sign_id', 'lifespan_mean_change_stat_sign_id', 'lifespan_median_change_stat_sign_id', 'lifespan_max_change_stat_sign_id'], 'integer'],
            [['age', 'lifespan_change_percent_male', 'lifespan_change_percent_female', 'lifespan_change_percent_common'], 'number'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference', 'pmid'], 'string', 'max' => 255],
            [['active_substance_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActiveSubstance::class, 'targetAttribute' => ['active_substance_id' => 'id']],
            [['active_substance_delivery_way_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActiveSubstanceDeliveryWay::class, 'targetAttribute' => ['active_substance_delivery_way_id' => 'id']],
            [['active_substance_dosage_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActiveSubstanceDosageUnit::class, 'targetAttribute' => ['active_substance_dosage_unit_id' => 'id']],
            [['treatment_end_time_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => TreatmentTimeUnit::class, 'targetAttribute' => ['treatment_end_time_unit_id' => 'id']],
            [['experiment_main_effect_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExperimentMainEffect::class, 'targetAttribute' => ['experiment_main_effect_id' => 'id']],
            [['treatment_period_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExperimentTreatmentPeriod::class, 'targetAttribute' => ['treatment_period_id' => 'id']],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['gene_intervention_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneIntervention::class, 'targetAttribute' => ['gene_intervention_id' => 'id']],
            [['gene_intervention_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneInterventionMethod::class, 'targetAttribute' => ['gene_intervention_method_id' => 'id']],
            [['intervention_result_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterventionResultForLongevity::class, 'targetAttribute' => ['intervention_result_id' => 'id']],
            [['lifespan_max_change_stat_sign_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatisticalSignificance::class, 'targetAttribute' => ['lifespan_max_change_stat_sign_id' => 'id']],
            [['lifespan_mean_change_stat_sign_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatisticalSignificance::class, 'targetAttribute' => ['lifespan_mean_change_stat_sign_id' => 'id']],
            [['lifespan_median_change_stat_sign_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatisticalSignificance::class, 'targetAttribute' => ['lifespan_median_change_stat_sign_id' => 'id']],
            [['lifespan_min_change_stat_sign_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatisticalSignificance::class, 'targetAttribute' => ['lifespan_min_change_stat_sign_id' => 'id']],
            [['model_organism_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelOrganism::class, 'targetAttribute' => ['model_organism_id' => 'id']],
            [['organism_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismLine::class, 'targetAttribute' => ['organism_line_id' => 'id']],
            [['organism_sex_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismSex::class, 'targetAttribute' => ['organism_sex_id' => 'id']],
            [['treatment_start_time_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => TreatmentTimeUnit::class, 'targetAttribute' => ['treatment_start_time_unit_id' => 'id']],
            [['treatment_end_stage_of_development_id'], 'exist', 'skipOnError' => true, 'targetClass' => TreatmentStageOfDevelopment::class, 'targetAttribute' => ['treatment_end_stage_of_development_id' => 'id']],
            [['treatment_start_stage_of_development_id'], 'exist', 'skipOnError' => true, 'targetClass' => TreatmentStageOfDevelopment::class, 'targetAttribute' => ['treatment_start_stage_of_development_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gene_id' => Yii::t('app', 'Gene ID'),
            'gene_intervention_id' => Yii::t('app', 'Gene Intervention ID'),
            'intervention_result_id' => Yii::t('app', 'Intervention Result ID'),
            'model_organism_id' => Yii::t('app', 'Model Organism ID'),
            'age' => Yii::t('app', 'Age'),
            'reference' => Yii::t('app', 'Reference'),
            'comment_en' => Yii::t('app', 'Comment En'),
            'comment_ru' => Yii::t('app', 'Comment Ru'),
            'sex' => Yii::t('app', 'Sex'),
            'organism_line_id' => Yii::t('app', 'Organism Line ID'),
            'lifespan_change_percent_male' => Yii::t('app', 'Lifespan Change Percent Male'),
            'lifespan_change_percent_female' => Yii::t('app', 'Lifespan Change Percent Female'),
            'lifespan_change_percent_common' => Yii::t('app', 'Lifespan Change Percent Common'),
            'age_unit' => Yii::t('app', 'Age Unit'),
            'genotype' => Yii::t('app', 'Genotype'),
            'pmid' => Yii::t('app', 'Pmid'),
            'tissue_specificity' => Yii::t('app', 'Tissue Specificity'),
            'active_substance_daily_dose' => Yii::t('app', 'Active Substance Daily Dose'),
            'active_substance_daily_doses_number' => Yii::t('app', 'Active Substance Daily Doses Number'),
            'treatment_start' => Yii::t('app', 'Treatment Start'),
            'treatment_end' => Yii::t('app', 'Treatment End'),
            'control_number' => Yii::t('app', 'Control Number'),
            'experiment_number' => Yii::t('app', 'Experiment Number'),
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
            'active_substance_id' => Yii::t('app', 'Active Substance ID'),
            'active_substance_delivery_way_id' => Yii::t('app', 'Active Substance Delivery Way ID'),
            'active_substance_dosage_unit_id' => Yii::t('app', 'Active Substance Dosage Unit ID'),
            'treatment_period_id' => Yii::t('app', 'Treatment Period ID'),
            'gene_intervention_method_id' => Yii::t('app', 'Gene Intervention Method ID'),
            'experiment_main_effect_id' => Yii::t('app', 'Experiment Main Effect ID'),
            'organism_sex_id' => Yii::t('app', 'Organism Sex ID'),
            'treatment_start_stage_of_development_id' => Yii::t('app', 'Treatment Start Stage Of Development ID'),
            'treatment_end_stage_of_development_id' => Yii::t('app', 'Treatment End Stage Of Development ID'),
            'treatment_start_time_unit_id' => Yii::t('app', 'Treatment Start Time Unit ID'),
            'treatment_end_time_unit_id' => Yii::t('app', 'Treatment End Time Unit ID'),
            'lifespan_min_change_stat_sign_id' => Yii::t('app', 'Lifespan Min Change Stat Sign ID'),
            'lifespan_mean_change_stat_sign_id' => Yii::t('app', 'Lifespan Mean Change Stat Sign ID'),
            'lifespan_median_change_stat_sign_id' => Yii::t('app', 'Lifespan Median Change Stat Sign ID'),
            'lifespan_max_change_stat_sign_id' => Yii::t('app', 'Lifespan Max Change Stat Sign ID'),
        ];
    }

    /**
     * Gets query for [[ActiveSubstance]].
     *
     * @return \yii\db\ActiveQuery|ActiveSubstanceQuery
     */
    public function getActiveSubstance()
    {
        return $this->hasOne(ActiveSubstance::class, ['id' => 'active_substance_id']);
    }

    /**
     * Gets query for [[ActiveSubstanceDeliveryWay]].
     *
     * @return \yii\db\ActiveQuery|ActiveSubstanceDeliveryWayQuery
     */
    public function getActiveSubstanceDeliveryWay()
    {
        return $this->hasOne(ActiveSubstanceDeliveryWay::class, ['id' => 'active_substance_delivery_way_id']);
    }

    /**
     * Gets query for [[ActiveSubstanceDosageUnit]].
     *
     * @return \yii\db\ActiveQuery|ActiveSubstanceDosageUnitQuery
     */
    public function getActiveSubstanceDosageUnit()
    {
        return $this->hasOne(ActiveSubstanceDosageUnit::class, ['id' => 'active_substance_dosage_unit_id']);
    }

    /**
     * Gets query for [[TreatmentEndTimeUnit]].
     *
     * @return \yii\db\ActiveQuery|TreatmentTimeUnitQuery
     */
    public function getTreatmentEndTimeUnit()
    {
        return $this->hasOne(TreatmentTimeUnit::class, ['id' => 'treatment_end_time_unit_id']);
    }

    /**
     * Gets query for [[ExperimentMainEffect]].
     *
     * @return \yii\db\ActiveQuery|ExperimentMainEffectQuery
     */
    public function getExperimentMainEffect()
    {
        return $this->hasOne(ExperimentMainEffect::class, ['id' => 'experiment_main_effect_id']);
    }

    /**
     * Gets query for [[TreatmentPeriod]].
     *
     * @return \yii\db\ActiveQuery|ExperimentTreatmentPeriodQuery
     */
    public function getTreatmentPeriod()
    {
        return $this->hasOne(ExperimentTreatmentPeriod::class, ['id' => 'treatment_period_id']);
    }

    /**
     * Gets query for [[Gene]].
     *
     * @return \yii\db\ActiveQuery|GeneQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::class, ['id' => 'gene_id']);
    }

    /**
     * Gets query for [[GeneIntervention]].
     *
     * @return \yii\db\ActiveQuery|GeneInterventionQuery
     */
    public function getGeneIntervention()
    {
        return $this->hasOne(GeneIntervention::class, ['id' => 'gene_intervention_id']);
    }

    /**
     * Gets query for [[GeneInterventionMethod]].
     *
     * @return \yii\db\ActiveQuery|GeneInterventionMethodQuery
     */
    public function getGeneInterventionMethod()
    {
        return $this->hasOne(GeneInterventionMethod::class, ['id' => 'gene_intervention_method_id']);
    }

    /**
     * Gets query for [[InterventionResult]].
     *
     * @return \yii\db\ActiveQuery|InterventionResultForLongevityQuery
     */
    public function getInterventionResult()
    {
        return $this->hasOne(InterventionResultForLongevity::class, ['id' => 'intervention_result_id']);
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
     * Gets query for [[ModelOrganism]].
     *
     * @return \yii\db\ActiveQuery|ModelOrganismQuery
     */
    public function getModelOrganism()
    {
        return $this->hasOne(ModelOrganism::class, ['id' => 'model_organism_id']);
    }

    /**
     * Gets query for [[OrganismLine]].
     *
     * @return \yii\db\ActiveQuery|OrganismLineQuery
     */
    public function getOrganismLine()
    {
        return $this->hasOne(OrganismLine::class, ['id' => 'organism_line_id']);
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
     * Gets query for [[TreatmentStartTimeUnit]].
     *
     * @return \yii\db\ActiveQuery|TreatmentTimeUnitQuery
     */
    public function getTreatmentStartTimeUnit()
    {
        return $this->hasOne(TreatmentTimeUnit::class, ['id' => 'treatment_start_time_unit_id']);
    }

    /**
     * Gets query for [[TreatmentEndStageOfDevelopment]].
     *
     * @return \yii\db\ActiveQuery|TreatmentStageOfDevelopmentQuery
     */
    public function getTreatmentEndStageOfDevelopment()
    {
        return $this->hasOne(TreatmentStageOfDevelopment::class, ['id' => 'treatment_end_stage_of_development_id']);
    }

    /**
     * Gets query for [[TreatmentStartStageOfDevelopment]].
     *
     * @return \yii\db\ActiveQuery|TreatmentStageOfDevelopmentQuery
     */
    public function getTreatmentStartStageOfDevelopment()
    {
        return $this->hasOne(TreatmentStageOfDevelopment::class, ['id' => 'treatment_start_stage_of_development_id']);
    }

    /**
     * Gets query for [[LifespanExperimentLinks]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentLinkQuery
     */
    public function getLifespanExperimentLinks()
    {
        return $this->hasMany(LifespanExperimentLink::class, ['lifespan_experiment_from_id' => 'id']);
    }

    /**
     * Gets query for [[LifespanExperimentLinks0]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentLinkQuery
     */
    public function getLifespanExperimentLinks0()
    {
        return $this->hasMany(LifespanExperimentLink::class, ['lifespan_experiment_to_id' => 'id']);
    }

    /**
     * Gets query for [[LifespanExperimentToTissues]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentToTissueQuery
     */
    public function getLifespanExperimentToTissues()
    {
        return $this->hasMany(LifespanExperimentToTissue::class, ['lifespan_experiment_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return LifespanExperimentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LifespanExperimentQuery(get_called_class());
    }
}
