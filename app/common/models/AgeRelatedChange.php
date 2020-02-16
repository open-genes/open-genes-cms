<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "age_related_change".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $age_related_change_type_id
 * @property int $sample_id
 * @property int $model_organism_id
 * @property int $organism_line_id
 * @property int $age_from
 * @property int $age_to
 * @property string $reference
 * @property string $comment_en
 * @property string $comment_ru
 * @property int $change_value_male
 * @property int $change_value_female
 * @property int $change_value_common
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
            [['gene_id', 'age_related_change_type_id', 'sample_id', 'model_organism_id', 'organism_line_id', 'age_from', 'age_to', 'change_value_male', 'change_value_female', 'change_value_common'], 'integer'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference'], 'string', 'max' => 255],
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
        ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getSample()
    {
        return $this->hasOne(Sample::className(), ['id' => 'sample_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
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
