<?php

namespace cms\models\common;

/**
 * This is the ActiveQuery class for [[Genotype]].
 *
 * @see Genotype
 */
class GenotypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Genotype[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Genotype|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
