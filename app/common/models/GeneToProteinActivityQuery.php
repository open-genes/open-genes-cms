<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[GeneToProteinActivity]].
 *
 * @see GeneToProteinActivity
 */
class GeneToProteinActivityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneToProteinActivity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneToProteinActivity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
