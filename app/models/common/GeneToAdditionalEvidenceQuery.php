<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[GeneToAdditionalEvidence]].
 *
 * @see GeneToAdditionalEvidence
 */
class GeneToAdditionalEvidenceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneToAdditionalEvidence[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneToAdditionalEvidence|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
