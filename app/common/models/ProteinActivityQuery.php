<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProteinActivity]].
 *
 * @see ProteinActivity
 */
class ProteinActivityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProteinActivity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProteinActivity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
