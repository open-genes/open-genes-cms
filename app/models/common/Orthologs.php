<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "orthologs".
 *
 * @property int $id
 * @property string|null $symbol
 * @property int|null $model_organism_id
 *
 * @property GeneToOrthologs[] $geneToOrthologs
 * @property ModelOrganism $organism
 */
class Orthologs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orthologs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_organism_id'], 'integer'],
            [['symbol'], 'string', 'max' => 255],
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
     * Gets query for [[GeneToOrthologs]].
     *
     * @return \yii\db\ActiveQuery|GeneToOrthologsQuery
     */
    public function getGeneToOrthologs()
    {
        return $this->hasMany(GeneToOrthologs::class, ['ortholog_id' => 'id']);
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
     * @return OrthologsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrthologsQuery(get_called_class());
    }
}
