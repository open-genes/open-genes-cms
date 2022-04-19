<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\Position]].
 *
 * @see \app\models\Position
 */
class PositionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Position[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Position|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
