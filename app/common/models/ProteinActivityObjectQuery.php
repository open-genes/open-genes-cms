<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProteinActivityObject]].
 *
 * @see ProteinActivityObject
 */
class ProteinActivityObjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProteinActivityObject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProteinActivityObject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
