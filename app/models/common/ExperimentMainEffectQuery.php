<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\ExperimentMainEffect]].
 *
 * @see \app\models\ExperimentMainEffect
 */
class ExperimentMainEffectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\ExperimentMainEffect[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\ExperimentMainEffect|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
