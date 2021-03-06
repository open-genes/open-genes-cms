<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[GeneToLongevityEffect]].
 *
 * @see GeneToLongevityEffect
 */
class GeneToLongevityEffectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneToLongevityEffect[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneToLongevityEffect|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
