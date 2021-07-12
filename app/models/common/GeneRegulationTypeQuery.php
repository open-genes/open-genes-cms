<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[GeneRegulationType]].
 *
 * @see GeneRegulationType
 */
class GeneRegulationTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneRegulationType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneRegulationType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
