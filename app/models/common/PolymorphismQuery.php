<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\Polymorphism]].
 *
 * @see \app\models\Polymorphism
 */
class PolymorphismQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Polymorphism[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Polymorphism|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
