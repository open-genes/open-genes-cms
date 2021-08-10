<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\ConditionActiveRecordTrait;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "sample".
 *
 */
class Sample extends common\Sample
{
    use RuEnActiveRecordTrait;
    use ConditionActiveRecordTrait;

    public $name;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
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

    public function getLinkedGenesIds()
    {
        return $this->getAgeRelatedChanges()
            ->select('gene_id')->distinct()->column();
    }

    public function search($params = [])
    {
        $query = self::find();

        if ($params) {
            $this->load($params);
        }
        $this->addCondition($query, 'id');
        $this->addCondition($query, 'name_en', true);
        $this->addCondition($query, 'name_ru', true);

        $query->leftJoin('age_related_change', 'age_related_change.sample_id=sample.id')
            ->groupBy('sample.id')
            ->andWhere('name_ru is not null or age_related_change.sample_id is not null');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->prepare();
        return $dataProvider;
    }

    public static function getAllNamesAsArray()
    {
        $names = parent::find()
            ->select(['sample.id', 'sample.name_ru', 'sample.name_en'])
            ->leftJoin('age_related_change', 'age_related_change.sample_id=sample.id')
            ->groupBy('sample.id')
            ->andWhere('name_ru is not null or age_related_change.sample_id is not null')
            ->asArray()
            ->all();
        $result = [];
        foreach ($names as $name) {
            $result[$name['id']] = "{$name['name_ru']} ({$name['name_en']})";
        }
        return $result;
    }

}
