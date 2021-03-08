<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "age_related_change_type".
 *
 * @property int $id
 * @property string $name_ru
 * @property string $name_en
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AgeRelatedChange[] $ageRelatedChanges
 */
class AgeRelatedChangeType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'age_related_change_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name_ru', 'name_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgeRelatedChanges()
    {
        return $this->hasMany(AgeRelatedChange::className(), ['age_related_change_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AgeRelatedChangeTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AgeRelatedChangeTypeQuery(get_called_class());
    }
}
