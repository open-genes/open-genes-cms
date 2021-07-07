<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_longevity_effect".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $longevity_effect_id
 * @property int|null $genotype_id
 * @property int|null $sex_of_organism
 * @property string|null $reference
 * @property string|null $comment_en
 * @property string|null $comment_ru
 * @property string|null $allele_variant
 * @property int|null $model_organism_id
 * @property int|null $data_type
 * @property int|null $age_related_change_type_id
 * @property string|null $pmid
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
            [['gene_id', 'longevity_effect_id', 'genotype_id', 'sex_of_organism', 'model_organism_id', 'data_type', 'age_related_change_type_id'], 'integer'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference', 'allele_variant', 'pmid'], 'string', 'max' => 255],
            [['age_related_change_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgeRelatedChangeType::className(), 'targetAttribute' => ['age_related_change_type_id' => 'id']],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['genotype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genotype::className(), 'targetAttribute' => ['genotype_id' => 'id']],
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
            'genotype_id' => 'Genotype ID',
            'sex_of_organism' => 'Sex Of Organism',
            'reference' => 'Reference',
            'comment_en' => 'Comment En',
            'comment_ru' => 'Comment Ru',
            'allele_variant' => 'Allele Variant',
            'model_organism_id' => 'Model Organism ID',
            'data_type' => 'Data Type',
            'age_related_change_type_id' => 'Age Related Change Type ID',
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
        return $this->hasOne(Genotype::className(), ['id' => 'genotype_id']);
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
