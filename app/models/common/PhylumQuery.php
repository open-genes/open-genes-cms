<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[Age]].
 *
 * @see Phylum
 */
class PhylumQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Phylum[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Phylum|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
