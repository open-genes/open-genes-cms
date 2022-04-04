<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "statistical_method".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property AgeRelatedChange[] $ageRelatedChanges
 */
class StatisticalMethod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statistical_method';
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
            'id' => 'ID',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
        ];
    }

    /**
     * Gets query for [[AgeRelatedChanges]].
     *
     * @return \yii\db\ActiveQuery|AgeRelatedChangeQuery
     */
    public function getAgeRelatedChanges()
    {
        return $this->hasMany(AgeRelatedChange::class, ['statistical_method_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return StatisticalMethodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatisticalMethodQuery(get_called_class());
    }
}
