<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\GeneToOrthologs]].
 *
 * @see \app\models\GeneToOrthologs
 */
class GeneToOrthologsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\GeneToOrthologs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\GeneToOrthologs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
