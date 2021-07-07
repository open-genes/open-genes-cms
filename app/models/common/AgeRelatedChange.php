<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "age_related_change".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $age_related_change_type_id
 * @property int|null $sample_id
 * @property int|null $model_organism_id
 * @property int|null $organism_line_id
 * @property float|null $age_from
 * @property float|null $age_to
 * @property string|null $reference
 * @property string|null $comment_en
 * @property string|null $comment_ru
 * @property float|null $change_value_male
 * @property float|null $change_value_female
 * @property float|null $change_value_common
 * @property int|null $age_unit
 * @property int|null $measurement_type
 * @property string|null $pmid
 *
 * @property Gene $gene
 * @property ModelOrganism $modelOrganism
 * @property OrganismLine $organismLine
 * @property Sample $sample
 * @property AgeRelatedChangeType $ageRelatedChangeType
 */
class AgeRelatedChange extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'age_related_change';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'age_related_change_type_id', 'sample_id', 'model_organism_id', 'organism_line_id', 'age_unit', 'measurement_type'], 'integer'],
            [['age_from', 'age_to', 'change_value_male', 'change_value_female', 'change_value_common'], 'number'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference', 'pmid'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['model_organism_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelOrganism::className(), 'targetAttribute' => ['model_organism_id' => 'id']],
            [['organism_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismLine::className(), 'targetAttribute' => ['organism_line_id' => 'id']],
            [['sample_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::className(), 'targetAttribute' => ['sample_id' => 'id']],
            [['age_related_change_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgeRelatedChangeType::className(), 'targetAttribute' => ['age_related_change_type_id' => 'id']],
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
            'age_related_change_type_id' => 'Age Related Change Type ID',
            'sample_id' => 'Sample ID',
            'model_organism_id' => 'Model Organism ID',
            'organism_line_id' => 'Organism Line ID',
            'age_from' => 'Age From',
            'age_to' => 'Age To',
            'reference' => 'Reference',
            'comment_en' => 'Comment En',
            'comment_ru' => 'Comment Ru',
            'change_value_male' => 'Change Value Male',
            'change_value_female' => 'Change Value Female',
            'change_value_common' => 'Change Value Common',
            'age_unit' => 'Age Unit',
            'measurement_type' => 'Measurement Type',
            'pmid' => 'Pmid',
        ];
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
     * Gets query for [[ModelOrganism]].
     *
     * @return \yii\db\ActiveQuery|ModelOrganismQuery
     */
    public function getModelOrganism()
    {
        return $this->hasOne(ModelOrganism::className(), ['id' => 'model_organism_id']);
    }

    /**
     * Gets query for [[OrganismLine]].
     *
     * @return \yii\db\ActiveQuery|OrganismLineQuery
     */
    public function getOrganismLine()
    {
        return $this->hasOne(OrganismLine::className(), ['id' => 'organism_line_id']);
    }

    /**
     * Gets query for [[Sample]].
     *
     * @return \yii\db\ActiveQuery|SampleQuery
     */
    public function getSample()
    {
        return $this->hasOne(Sample::className(), ['id' => 'sample_id']);
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
     * {@inheritdoc}
     * @return AgeRelatedChangeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AgeRelatedChangeQuery(get_called_class());
    }
}
