<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_longevity_effect".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $longevity_effect_id
 * @property int|null $polymorphism_id
 * @property int|null $sex_of_organism
 * @property int|null $n_of_controls
 * @property int|null $n_of_experiment
 * @property int|null $significance
 * @property float|null $frequency_controls
 * @property float|null $frequency_experiment
 * @property string|null $reference
 * @property string|null $comment_en
 * @property string|null $comment_ru
 * @property string|null $allele_variant
 * @property string|null $non_associated_allele
 * @property string|null $nucleotide_change
 * @property string|null $amino_acid_change
 * @property int|null $data_type
 * @property int|null $age_related_change_type_id
 * @property int|null $position_id
 * @property int|null $polymorphism_type_id
 * @property int|null $ethnicity_id
 * @property int|null $study_type_id
 * @property string|null $pmid
 * @property float|null $min_age_of_controls
 * @property float|null $max_age_of_controls
 * @property float|null $mean_age_of_controls
 * @property float|null $min_age_of_experiment
 * @property float|null $max_age_of_experiment
 * @property float|null $mean_age_of_experiment
 *
 * @property AgeRelatedChangeType $ageRelatedChangeType
 * @property Gene $gene
 * @property Genotype $genotype
 * @property LongevityEffect $longevityEffect
 */
class GeneToLongevityEffect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_longevity_effect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'longevity_effect_id', 'polymorphism_id', 'sex_of_organism', 'data_type', 'age_related_change_type_id', 'position_id', 'polymorphism_type_id', 'significance', 'n_of_controls', 'n_of_experiment', 'ethnicity_id', 'study_type_id'], 'integer'],
            [['comment_en', 'comment_ru', 'non_associated_allele', 'amino_acid_change', 'nucleotide_change'], 'string'],
            [['frequency_controls', 'frequency_experiment', 'min_age_of_controls', 'max_age_of_controls', 'mean_age_of_controls', 'min_age_of_experiment', 'max_age_of_experiment', 'mean_age_of_experiment'], 'number'],
            [['reference', 'allele_variant', 'pmid'], 'string', 'max' => 255],
            [['age_related_change_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgeRelatedChangeType::className(), 'targetAttribute' => ['age_related_change_type_id' => 'id']],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['polymorphism_id'], 'exist', 'skipOnError' => true, 'targetClass' => Polymorphism::class, 'targetAttribute' => ['polymorphism_id' => 'id']],
            [['longevity_effect_id'], 'exist', 'skipOnError' => true, 'targetClass' => LongevityEffect::className(), 'targetAttribute' => ['longevity_effect_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gene_id' => 'Gene ID',
            'longevity_effect_id' => 'Longevity Effect ID',
            'polymorphism_id' => 'Polymorphism ID',
            'sex_of_organism' => 'Sex Of Organism',
            'reference' => 'Reference',
            'comment_en' => 'Comment En',
            'comment_ru' => 'Comment Ru',
            'allele_variant' => 'Allele Variant',
            'data_type' => 'Data Type',
            'age_related_change_type_id' => 'Age Related Change Type ID',
            'position_id' => 'Position id',
            'polymorphism_type_id' => 'Polymorphism type id',
            'significance' => 'Значимость',
            'pmid' => 'Pmid',
        ];
    }

    /**
     * Gets query for [[AgeRelatedChangeType]].
     *
     * @return \yii\db\ActiveQuery|AgeRelatedChangeTypeQuery
     */
    public function getAgeRelatedChangeType()
    {
        return $this->hasOne(AgeRelatedChangeType::className(), ['id' => 'age_related_change_type_id']);
    }

    /**
     * Gets query for [[Gene]].
     *
     * @return \yii\db\ActiveQuery|GeneQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['id' => 'gene_id']);
    }

    /**
     * Gets query for [[Genotype]].
     *
     * @return \yii\db\ActiveQuery|GenotypeQuery
     */
    public function getGenotype()
    {
        return $this->hasOne(Polymorphism::class, ['id' => 'polymorphism_id']);
    }

    /**
     * Gets query for [[LongevityEffect]].
     *
     * @return \yii\db\ActiveQuery|LongevityEffectQuery
     */
    public function getLongevityEffect()
    {
        return $this->hasOne(LongevityEffect::className(), ['id' => 'longevity_effect_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneToLongevityEffectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToLongevityEffectQuery(get_called_class());
    }
}
