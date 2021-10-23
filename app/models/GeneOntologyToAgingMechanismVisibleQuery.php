<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[GeneOntologyToAgingMechanismVisible]].
 *
 * @see GeneOntologyToAgingMechanismVisible
 */
class GeneOntologyToAgingMechanismVisibleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneOntologyToAgingMechanismVisible[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneOntologyToAgingMechanismVisible|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
