<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "protein_activity".
 *
 * @property int $id
 * @property string $name_en
 * @property string $name_ru
 * @property int $created_at
 * @property int $updated_at

 */
class ProteinActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'protein_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name_en', 'name_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_en' => 'Name En',
            'name_ru' => 'Name Ru',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProteinActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProteinActivityQuery(get_called_class());
    }
}
