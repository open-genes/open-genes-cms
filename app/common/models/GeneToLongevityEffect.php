<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gene_to_longevity_effect".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $longevity_effect_id
 * @property int $gene_longevity_association_type_id
 * @property int $model_organism_id
 * @property int $organism_line_id
 * @property int $genotype_id
 * @property int $sex_of_organism
 * @property string $reference
 * @property string $comment_en
 * @property string $comment_ru
 *
 * @property GeneLongevityAssociationType $geneLongevityAssociationType
 * @property Gene $gene
 * @property Genotype $genotype
 * @property LongevityEffect $longevityEffect
 * @property ModelOrganism $modelOrganism
 * @property OrganismLine $organismLine
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
            [['gene_id', 'longevity_effect_id', 'gene_longevity_association_type_id', 'model_organism_id', 'organism_line_id', 'genotype_id', 'sex_of_organism'], 'integer'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference'], 'string', 'max' => 255],
            [['gene_longevity_association_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneLongevityAssociationType::className(), 'targetAttribute' => ['gene_longevity_association_type_id' => 'id']],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['genotype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genotype::className(), 'targetAttribute' => ['genotype_id' => 'id']],
            [['longevity_effect_id'], 'exist', 'skipOnError' => true, 'targetClass' => LongevityEffect::className(), 'targetAttribute' => ['longevity_effect_id' => 'id']],
            [['model_organism_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelOrganism::className(), 'targetAttribute' => ['model_organism_id' => 'id']],
            [['organism_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismLine::className(), 'targetAttribute' => ['organism_line_id' => 'id']],
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
            'gene_longevity_association_type_id' => 'Gene Longevity Association Type ID',
            'model_organism_id' => 'Model Organism ID',
            'organism_line_id' => 'Organism Line ID',
            'genotype_id' => 'Genotype ID',
            'sex_of_organism' => 'Sex Of Organism',
            'reference' => 'Reference',
            'comment_en' => 'Comment En',
            'comment_ru' => 'Comment Ru',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneLongevityAssociationType()
    {
        return $this->hasOne(GeneLongevityAssociationType::className(), ['id' => 'gene_longevity_association_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['id' => 'gene_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenotype()
    {
        return $this->hasOne(Genotype::className(), ['id' => 'genotype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLongevityEffect()
    {
        return $this->hasOne(LongevityEffect::className(), ['id' => 'longevity_effect_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelOrganism()
    {
        return $this->hasOne(ModelOrganism::className(), ['id' => 'model_organism_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganismLine()
    {
        return $this->hasOne(OrganismLine::className(), ['id' => 'organism_line_id']);
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
