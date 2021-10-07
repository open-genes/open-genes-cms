<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\LifespanExperimentLink]].
 *
 * @see \app\models\LifespanExperimentLink
 */
class LifespanExperimentLinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\LifespanExperimentLink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\LifespanExperimentLink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
