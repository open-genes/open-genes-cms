<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
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
class GeneInterventionWay extends \app\models\common\GeneInterventionWay
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
                ];
    }


    /**
    * Gets query for [[GeneInterventionMethods]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\GeneInterventionMethodQuery
    */
    public function getGeneInterventionMethods()
    {
    return $this->hasMany(GeneInterventionMethod::class, ['gene_intervention_way_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
