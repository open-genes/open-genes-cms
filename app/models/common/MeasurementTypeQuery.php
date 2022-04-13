<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\MeasurementType]].
 *
 * @see \app\models\MeasurementType
 */
class MeasurementTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\MeasurementType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\MeasurementType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
