<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\PolymorphismType]].
 *
 * @see \app\models\PolymorphismType
 */
class PolymorphismTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\PolymorphismType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\PolymorphismType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
