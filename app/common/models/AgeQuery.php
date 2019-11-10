<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Age]].
 *
 * @see Age
 */
class AgeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Age[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Age|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
