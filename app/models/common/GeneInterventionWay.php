<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_intervention_way".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property GeneInterventionMethod[] $geneInterventionMethods
 */
class GeneInterventionWay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_intervention_way';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_en'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[GeneInterventionMethods]].
     *
     * @return \yii\db\ActiveQuery|GeneInterventionMethodQuery
     */
    public function getGeneInterventionMethods()
    {
        return $this->hasMany(GeneInterventionMethod::class, ['gene_intervention_way_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneInterventionWayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneInterventionWayQuery(get_called_class());
    }
}
