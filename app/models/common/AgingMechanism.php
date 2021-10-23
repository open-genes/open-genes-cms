<?php

namespace app\models\common;

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
class AgingMechanism extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aging_mechanism';
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
     * Gets query for [[AgingMechanismToGeneOntologies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgingMechanismToGeneOntologies()
    {
        return $this->hasMany(AgingMechanismToGeneOntology::class, ['aging_mechanism_id' => 'id']);
    }
}
