<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[InterventionResult]].
 *
 * @see InterventionResultForLongevity
 */
class InterventionResultForLongevityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return InterventionResultForLongevity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return InterventionResultForLongevity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
