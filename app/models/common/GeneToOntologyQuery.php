<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[GeneToOntology]].
 *
 * @see GeneToOntology
 */
class GeneToOntologyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneToOntology[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneToOntology|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
