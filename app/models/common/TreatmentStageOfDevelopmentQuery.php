<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\TreatmentStageOfDevelopment]].
 *
 * @see \app\models\TreatmentStageOfDevelopment
 */
class TreatmentStageOfDevelopmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\TreatmentStageOfDevelopment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\TreatmentStageOfDevelopment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
