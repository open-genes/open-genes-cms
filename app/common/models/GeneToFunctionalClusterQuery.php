<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[GeneToFunctionalCluster]].
 *
 * @see GeneToFunctionalCluster
 */
class GeneToFunctionalClusterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneToFunctionalCluster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneToFunctionalCluster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
