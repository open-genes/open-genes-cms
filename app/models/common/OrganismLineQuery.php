<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[OrganismLine]].
 *
 * @see OrganismLine
 */
class OrganismLineQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OrganismLine[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OrganismLine|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
