<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
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
class GeneInterventionMethod extends \app\models\common\GeneInterventionMethod
{
    use RuEnActiveRecordTrait;

    public $name;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            ChangelogBehavior::class
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
    
    public static function getAllNamesByWays()
    {
        $names = self::find()
            ->select(['gene_intervention_way.name_ru way_ru', 'gene_intervention_way.name_en way_en', 'gene_intervention_method.id', 'gene_intervention_method.name_ru', 'gene_intervention_method.name_en'])
            ->asArray()
            ->leftJoin('gene_intervention_way', 'gene_intervention_method.gene_intervention_way_id=gene_intervention_way.id')
            ->all();
        $result = [];
        foreach ($names as $name) {
            if(!$name['way']) {
                $name['way'] = 'other';
            }
            $result["{$name['way_ru']} ({$name['way_en']})"][$name['id']] = "{$name['name_ru']} ({$name['name_en']})";
        }
        return $result;
    }


    /**
     * Gets query for [[GeneInterventionWay]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\GeneInterventionWayQuery
     */
    public function getGeneInterventionWay()
    {
        return $this->hasOne(GeneInterventionWay::class, ['id' => 'gene_intervention_way_id']);
    }

    /**
     * Gets query for [[LifespanExperiments]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::class, ['gene_intervention_method_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
