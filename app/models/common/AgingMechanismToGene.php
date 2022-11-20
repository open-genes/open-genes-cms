<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "aging_mechanism_to_gene".
 *
 * @property string $uuid [uuid]
 * @property int $gene_id
 * @property int $aging_mechanism_id
 *
 * @property AgingMechanism $agingMechanism
 * @property Gene $gene
 */
class AgingMechanismToGene extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aging_mechanism_to_gene';
    }

    /**
     * @return array
     */
    public static function primaryKey()
    {
        return ['uuid'];
    }

    public static function getId()
    {
        return self::primaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'aging_mechanism_id'], 'integer'],
            [['aging_mechanism_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgingMechanism::class, 'targetAttribute' => ['aging_mechanism_id' => 'id']],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
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
