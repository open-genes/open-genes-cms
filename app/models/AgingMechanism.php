<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "aging_mechanism".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property AgingMechanismToGeneOntology[] $agingMechanismToGeneOntologies
 */
class AgingMechanism extends \app\models\common\AgingMechanism
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
    * Gets query for [[AgingMechanismToGeneOntologies]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getAgingMechanismToGeneOntologies()
    {
    return $this->hasMany(AgingMechanismToGeneOntology::class, ['aging_mechanism_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }
    
    public function getGeneOntologyVisible()
    {
        return GeneOntologyToAgingMechanismVisible::find()
            ->where(['aging_mechanism_id' => $this->id])
            ->all();
    }
    
    public function getGeneOntologyTree()
    {
        $currentOntology = AgingMechanismToGeneOntology::find()
            ->where(['aging_mechanism_id' => $this->id])
            ->all();
        var_dump($currentOntology);
    }

}
