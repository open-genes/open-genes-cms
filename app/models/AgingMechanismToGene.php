<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "aging_mechanism_to_gene".
 *
 * @property string $uuid [uuid]
 * @property int $gene_id
 * @property int $aging_mechanism_id
 *
 * @property AgingMechanism $agingMechanism
 * @property Gene $geneOntology
 */
class AgingMechanismToGene extends \app\models\common\AgingMechanismToGene
{
    use RuEnActiveRecordTrait;

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
            'uuid' => Yii::t('app', 'UUID'),
            'gene_id' => Yii::t('app', 'Gene ID'),
            'aging_mechanism_id' => Yii::t('app', 'Aging Mechanism ID'),
        ];
    }


    /**
    * Gets query for [[AgingMechanism]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getAgingMechanism()
    {
        return $this->hasOne(AgingMechanism::class, ['id' => 'aging_mechanism_id']);
    }

    /**
    * Gets query for [[Gene]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getGene()
    {
        return $this->hasOne(Gene::class, ['id' => 'gene_id']);
    }

}
