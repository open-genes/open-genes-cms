<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[InterventionResult]].
 *
 * @see InterventionResult
 */
class InterventionResultQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return InterventionResult[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return InterventionResult|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
