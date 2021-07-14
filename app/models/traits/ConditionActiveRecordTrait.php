<?php


namespace app\models\traits;


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
}