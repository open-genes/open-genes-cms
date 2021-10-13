<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "source".
 *
 * @property int $id
 * @property string|null $name
 *
 */
class Source extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'source';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Gene]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGene()
    {
        return $this->hasMany(Gene::class, ['id' => 'gene_id'])
            ->viaTable('gene_to_source', ['source_id' => 'id']);
    }
}
