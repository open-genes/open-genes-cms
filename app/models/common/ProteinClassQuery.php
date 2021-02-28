<?php

namespace cms\models\common;

/**
 * This is the ActiveQuery class for [[ProteinClass]].
 *
 * @see ProteinClass
 */
class ProteinClassQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProteinClass[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProteinClass|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
