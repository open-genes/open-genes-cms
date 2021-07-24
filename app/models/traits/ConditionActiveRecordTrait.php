<?php


namespace app\models\traits;


use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

trait ConditionActiveRecordTrait
{
    /**
     * @param $query ActiveQuery
     * @param string $attribute
     * @param bool $partialMatch
     */
    protected function addCondition(ActiveQuery &$query, string $attribute, bool $partialMatch = false)
    {
        $values = explode(',', $this->$attribute);
        if (trim(current($values)) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $values]);
        } else {
            $query->andWhere(['in', $attribute, $values]);
        }
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->prepare();
        return $dataProvider;
    }
}