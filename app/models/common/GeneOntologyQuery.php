<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[GeneOntology]].
 *
 * @see GeneOntology
 */
class GeneOntologyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneOntology[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneOntology|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
