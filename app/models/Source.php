<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\ConditionActiveRecordTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;


class Source extends common\Source
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
            $result[$model->id] = $model->name;
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
        $this->addCondition($query, 'name', true);

        return $dataProvider;
    }
}
