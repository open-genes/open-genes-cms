<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[LifespanExperiment]].
 *
 * @see LifespanExperiment
 */
class LifespanExperimentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LifespanExperiment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LifespanExperiment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
