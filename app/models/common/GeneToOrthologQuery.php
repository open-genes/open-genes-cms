<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[\app\models\GeneToOrtholog]].
 *
 * @see \app\models\GeneToOrtholog
 */
class GeneToOrthologQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\GeneToOrtholog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\GeneToOrtholog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
