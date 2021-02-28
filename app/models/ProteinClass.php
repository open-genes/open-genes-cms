<?php

namespace cms\models;

use cms\models\behaviors\ChangelogBehavior;
use cms\models\traits\ConditionActiveRecordTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "age".
 *
 */
class ProteinClass extends common\ProteinClass
{
    use ConditionActiveRecordTrait;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }

    public static function findAllAsArray()
    {
        $result = [];
        $models = self::find()->all();
        foreach ($models as $model) {
            $result[$model->id] = $model->name_en;
        }

        return $result;
    }

    public function search($params = [])
    {
        $query = self::find();

        if($params) {
            $this->load($params);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->addCondition($query, 'name_en', true);
        $this->addCondition($query, 'name_ru', true);

        return $dataProvider;
    }
}
