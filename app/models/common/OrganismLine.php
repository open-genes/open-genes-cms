<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "organism_line".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AgeRelatedChange[] $ageRelatedChanges
 * @property GeneInterventionToVitalProcess[] $geneInterventionToVitalProcesses
 * @property LifespanExperiment[] $lifespanExperiments
 */
class OrganismLine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organism_line';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name_ru', 'name_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
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
        return $this->hasMany(AgeRelatedChange::className(), ['organism_line_id' => 'id']);
    }

    /**
     * Gets query for [[GeneInterventionToVitalProcesses]].
     *
     * @return \yii\db\ActiveQuery|GeneInterventionToVitalProcessQuery
     */
    public function getGeneInterventionToVitalProcesses()
    {
        return $this->hasMany(GeneInterventionToVitalProcess::className(), ['organism_line_id' => 'id']);
    }

    /**
     * Gets query for [[LifespanExperiments]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::className(), ['organism_line_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OrganismLineQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrganismLineQuery(get_called_class());
    }
}
