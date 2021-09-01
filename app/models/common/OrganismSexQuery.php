<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\OrganismSex]].
 *
 * @see \app\models\OrganismSex
 */
class OrganismSexQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\OrganismSex[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\OrganismSex|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
