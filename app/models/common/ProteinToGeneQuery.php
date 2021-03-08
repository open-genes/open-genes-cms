<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[ProteinToGene]].
 *
 * @see ProteinToGene
 */
class ProteinToGeneQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProteinToGene[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProteinToGene|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
