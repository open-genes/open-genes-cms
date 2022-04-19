<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "lifespan_experiment".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $gene_intervention_id
 * @property float|null $age
 * @property string|null $reference
 * @property string|null $comment_en
 * @property string|null $comment_ru
 * @property int|null $organism_line_id
 * @property int|null $age_unit
 * @property int|null $genotype
 * @property string|null $pmid
 * @property int|null $tissue_specificity Тканеспецифичность
 * @property string|null $tissue_specific_promoter Тканеспецифичный промотер
 * @property int|null $mutation_induction Индукция мутации отменой препарата
 * @property float|null $treatment_start Начало периода воздействия
 * @property float|null $treatment_end Конец периода воздействия
 * @property int|null $active_substance_id
 * @property int|null $active_substance_delivery_way_id
 * @property int|null $treatment_period_id
 * @property int|null $gene_intervention_method_id
 * @property int|null $experiment_main_effect_id
 * @property int|null $treatment_start_stage_of_development_id
 * @property int|null $treatment_end_stage_of_development_id
 * @property int|null $treatment_start_time_unit_id
 * @property int|null $treatment_end_time_unit_id
 * @property int|null $general_lifespan_experiment_id
 * @property string|null $description_of_therapy_ru
 * @property string|null $description_of_therapy_en
 * @property string|null $type
 *
 * @property ActiveSubstance $activeSubstance
 * @property ActiveSubstanceDeliveryWay $activeSubstanceDeliveryWay
 * @property GeneralLifespanExperiment $generalLifespanExperiment
 * @property TimeUnit $treatmentEndTimeUnit
 * @property ExperimentMainEffect $experimentMainEffect
 * @property ExperimentTreatmentPeriod $treatmentPeriod
 * @property Gene $gene
 * @property GeneIntervention $geneIntervention
 * @property GeneInterventionMethod $geneInterventionMethod
 * @property InterventionResultForLongevity $interventionResult
 * @property ModelOrganism $modelOrganism
 * @property OrganismLine $organismLine
 * @property TimeUnit $treatmentStartTimeUnit
 * @property TreatmentStageOfDevelopment $treatmentEndStageOfDevelopment
 * @property TreatmentStageOfDevelopment $treatmentStartStageOfDevelopment
 * @property LifespanExperimentToInterventionWay[] $lifespanExperimentToInterventionWays
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
            [['gene_id', 'gene_intervention_id', 'organism_line_id', 'age_unit', 'genotype', 'tissue_specificity', 'mutation_induction', 'active_substance_id', 'active_substance_delivery_way_id', 'treatment_period_id', 'gene_intervention_method_id', 'experiment_main_effect_id', 'treatment_start_stage_of_development_id', 'treatment_end_stage_of_development_id', 'treatment_start_time_unit_id', 'treatment_end_time_unit_id', 'general_lifespan_experiment_id', 'gene_intervention_way_id'], 'integer'],
            [['age', 'treatment_start', 'treatment_end'], 'number'],
            [['comment_en', 'comment_ru', 'type', 'tissue_specific_promoter', 'description_of_therapy_ru', 'description_of_therapy_en'], 'string'],
            [['reference', 'pmid'], 'string', 'max' => 255],
            [['active_substance_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActiveSubstance::class, 'targetAttribute' => ['active_substance_id' => 'id']],
            [['active_substance_delivery_way_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActiveSubstanceDeliveryWay::class, 'targetAttribute' => ['active_substance_delivery_way_id' => 'id']],
            [['general_lifespan_experiment_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneralLifespanExperiment::class, 'targetAttribute' => ['general_lifespan_experiment_id' => 'id']],
            [['treatment_end_time_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => TimeUnit::class, 'targetAttribute' => ['treatment_end_time_unit_id' => 'id']],
            [['experiment_main_effect_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExperimentMainEffect::class, 'targetAttribute' => ['experiment_main_effect_id' => 'id']],
            [['treatment_period_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExperimentTreatmentPeriod::class, 'targetAttribute' => ['treatment_period_id' => 'id']],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['gene_intervention_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneIntervention::class, 'targetAttribute' => ['gene_intervention_id' => 'id']],
            [['gene_intervention_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneInterventionMethod::class, 'targetAttribute' => ['gene_intervention_method_id' => 'id']],
            [['organism_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismLine::class, 'targetAttribute' => ['organism_line_id' => 'id']],
            [['treatment_start_time_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => TimeUnit::class, 'targetAttribute' => ['treatment_start_time_unit_id' => 'id']],
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
            'age' => Yii::t('app', 'Age'),
            'reference' => Yii::t('app', 'Reference'),
            'comment_en' => Yii::t('app', 'Comment En'),
            'comment_ru' => Yii::t('app', 'Comment Ru'),
            'organism_line_id' => Yii::t('app', 'Organism Line ID'),
            'lifespan_change_percent_male' => Yii::t('app', 'Lifespan Change Percent Male'),
            'lifespan_change_percent_female' => Yii::t('app', 'Lifespan Change Percent Female'),
            'lifespan_change_percent_common' => Yii::t('app', 'Lifespan Change Percent Common'),
            'age_unit' => Yii::t('app', 'Age Unit'),
            'genotype' => Yii::t('app', 'Genotype'),
            'pmid' => Yii::t('app', 'Pmid'),
            'tissue_specificity' => Yii::t('app', 'Tissue Specificity'),
            'tissue_specific_promoter' => Yii::t('app', 'Tissue Specific Promoter'),
            'mutation_induction' => Yii::t('app', 'Mutation induction by drug withdrawal'),
            'treatment_start' => Yii::t('app', 'Treatment Start'),
            'treatment_end' => Yii::t('app', 'Treatment End'),
            'active_substance_id' => Yii::t('app', 'Active Substance ID'),
            'active_substance_delivery_way_id' => Yii::t('app', 'Active Substance Delivery Way ID'),
            'treatment_period_id' => Yii::t('app', 'Treatment Period ID'),
            'gene_intervention_method_id' => Yii::t('app', 'Gene Intervention Method ID'),
            'experiment_main_effect_id' => Yii::t('app', 'Experiment Main Effect ID'),
            'treatment_start_stage_of_development_id' => Yii::t('app', 'Treatment Start Stage Of Development ID'),
            'treatment_end_stage_of_development_id' => Yii::t('app', 'Treatment End Stage Of Development ID'),
            'treatment_start_time_unit_id' => Yii::t('app', 'Treatment Start Time Unit ID'),
            'treatment_end_time_unit_id' => Yii::t('app', 'Treatment End Time Unit ID'),
            'general_lifespan_experiment_id' => Yii::t('app', 'General Lifespan Experiment ID'),
            'type' => Yii::t('app', 'Type'),
            'description_of_therapy_ru' => Yii::t('app', 'Description of therapy'),
            'description_of_therapy_en' => Yii::t('app', 'Description of therapy EN'),
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
     * Gets query for [[GeneralLifespanExperiment]].
     *
     * @return \yii\db\ActiveQuery|GeneralLifespanExperimentQuery
     */
    public function getGeneralLifespanExperiment()
    {
        return $this->hasOne(GeneralLifespanExperiment::class, ['id' => 'general_lifespan_experiment_id']);
    }

    /**
     * Gets query for [[TreatmentEndTimeUnit]].
     *
     * @return \yii\db\ActiveQuery|TreatmentTimeUnitQuery
     */
    public function getTreatmentEndTimeUnit()
    {
        return $this->hasOne(TimeUnit::class, ['id' => 'treatment_end_time_unit_id']);
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
     * Gets query for [[OrganismLine]].
     *
     * @return \yii\db\ActiveQuery|OrganismLineQuery
     */
    public function getOrganismLine()
    {
        return $this->hasOne(OrganismLine::class, ['id' => 'organism_line_id']);
    }

    /**
     * Gets query for [[TreatmentStartTimeUnit]].
     *
     * @return \yii\db\ActiveQuery|TreatmentTimeUnitQuery
     */
    public function getTreatmentStartTimeUnit()
    {
        return $this->hasOne(TimeUnit::class, ['id' => 'treatment_start_time_unit_id']);
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
     * Gets query for [[LifespanExperimentToInterventionWays]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentToInterventionWayQuery
     */
    public function getLifespanExperimentToInterventionWays()
    {
        return $this->hasMany(LifespanExperimentToInterventionWay::class, ['lifespan_experiment_id' => 'id']);
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
