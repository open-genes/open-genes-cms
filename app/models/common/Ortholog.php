<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "ortholog".
 *
 * @property int $id
 * @property string|null $symbol
 * @property int|null $model_organism_id
 *
 * @property GeneToOrtholog[] $geneToOrtholog
 * @property ModelOrganism $organism
 */
class Ortholog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ortholog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_organism_id'], 'integer'],
            [['symbol'], 'string', 'max' => 255],
            [['external_base_name'], 'string', 'max' => 255],
            [['external_base_id'], 'string', 'max' => 255],
            [['model_organism_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelOrganism::class, 'targetAttribute' => ['model_organism_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symbol' => 'Symbol',
            'model_organism_id' => 'Organism ID',
        ];
    }

    /**
     * Gets query for [[GeneToOrtholog]].
     *
     * @return \yii\db\ActiveQuery|GeneToOrthologQuery
     */
    public function getGeneToOrtholog()
    {
        return $this->hasMany(GeneToOrtholog::class, ['ortholog_id' => 'id']);
    }

    /**
     * Gets query for [[Organism]].
     *
     * @return \yii\db\ActiveQuery|ModelOrganismQuery
     */
    public function getOrganism()
    {
        return $this->hasOne(ModelOrganism::class, ['id' => 'model_organism_id']);
    }

    /**
     * {@inheritdoc}
     * @return OrthologQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrthologQuery(get_called_class());
    }
}
