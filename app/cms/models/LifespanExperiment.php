<?php

namespace cms\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class LifespanExperiment extends \common\models\LifespanExperiment
{
    public $delete = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['gene_id', 'gene_intervention_id', 'intervention_result_id'], 'required'],
        ]);
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить'
        ]);
    }

    public static function findAllAsArray()
    {
        $result = [];
        $ages = self::find()->all();
        foreach ($ages as $age) {
            $result[$age->id] = $age->name_phylo;
        }

        return $result;
    }

    /**
     * @param LifespanExperiment[] $lifespanExperiments
     * @param int $geneId
     */
    public static function saveMultipleForGene(array $lifespanExperiments, int $geneId)
    {

    }

}
