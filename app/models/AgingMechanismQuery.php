<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AgingMechanism]].
 *
 * @see AgingMechanism
 */
class AgingMechanismQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AgingMechanism[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AgingMechanism|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
