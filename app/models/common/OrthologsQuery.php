<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\Orthologs]].
 *
 * @see \app\models\Orthologs
 */
class OrthologsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Orthologs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Orthologs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
