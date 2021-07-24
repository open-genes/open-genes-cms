<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "sample".
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ru
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AgeRelatedChange[] $ageRelatedChanges
 * @property GeneExpressionInSample[] $geneExpressionInSamples
 */
class Sample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sample';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name_en', 'name_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_en' => 'Name En',
            'name_ru' => 'Name Ru',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AgeRelatedChanges]].
     *
     * @return \yii\db\ActiveQuery|AgeRelatedChangeQuery
     */
    public function getAgeRelatedChanges()
    {
        return $this->hasMany(AgeRelatedChange::className(), ['sample_id' => 'id']);
    }

    /**
     * Gets query for [[GeneExpressionInSamples]].
     *
     * @return \yii\db\ActiveQuery|GeneExpressionInSampleQuery
     */
    public function getGeneExpressionInSamples()
    {
        return $this->hasMany(GeneExpressionInSample::className(), ['sample_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SampleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SampleQuery(get_called_class());
    }
}
