<?php


namespace cms\models\traits;


use yii\db\ActiveQuery;

trait ConditionActiveRecordTrait
{
    /**
     * @param $query ActiveQuery
     * @param $attribute
     * @param bool $partialMatch
     */
    protected function addCondition(&$query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}