<?php

namespace cms\models\common;

/**
 * This is the ActiveQuery class for [[GeneIntervention]].
 *
 * @see GeneIntervention
 */
class GeneInterventionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneIntervention[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneIntervention|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
