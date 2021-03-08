<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[GeneToProteinClass]].
 *
 * @see GeneToProteinClass
 */
class GeneToProteinClassQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneToProteinClass[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneToProteinClass|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
