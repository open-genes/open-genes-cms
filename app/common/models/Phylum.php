<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "age".
 *
 * @property int $id
 * @property string $name_phylo
 * @property string $name_mya
 * @property int $order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Gene[] $genes
 */
class Phylum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'age';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order', 'created_at', 'updated_at'], 'integer'],
            [['name_phylo', 'name_mya'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_phylo' => 'Name Phylo',
            'name_mya' => 'Name Mya',
            'order' => 'Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenes()
    {
        return $this->hasMany(Gene::className(), ['age_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PhylumQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhylumQuery(get_called_class());
    }
}
