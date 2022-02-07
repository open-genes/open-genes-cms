<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\Ortholog]].
 *
 * @see \app\models\Ortholog
 */
class OrthologQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Ortholog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Ortholog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
