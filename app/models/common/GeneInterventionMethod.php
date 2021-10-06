<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_intervention_method".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property int|null $gene_intervention_way_id
 *
 * @property GeneInterventionWay $geneInterventionWay
 * @property LifespanExperiment[] $lifespanExperiments
 */
class GeneInterventionMethod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_intervention_method';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_intervention_way_id'], 'integer'],
            [['name_ru', 'name_en'], 'string', 'max' => 255],
            [['gene_intervention_way_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneInterventionWay::class, 'targetAttribute' => ['gene_intervention_way_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_en' => Yii::t('app', 'Name En'),
            'gene_intervention_way_id' => Yii::t('app', 'Gene Intervention Way ID'),
        ];
    }

    /**
     * Gets query for [[GeneInterventionWay]].
     *
     * @return \yii\db\ActiveQuery|GeneInterventionWayQuery
     */
    public function getGeneInterventionWay()
    {
        return $this->hasOne(GeneInterventionWay::class, ['id' => 'gene_intervention_way_id']);
    }

    /**
     * Gets query for [[LifespanExperiments]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::class, ['gene_intervention_method_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneInterventionMethodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneInterventionMethodQuery(get_called_class());
    }
}
