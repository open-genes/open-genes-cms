<?php

namespace cms\models\common;

/**
 * This is the ActiveQuery class for [[FunctionalCluster]].
 *
 * @see FunctionalCluster
 */
class FunctionalClusterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FunctionalCluster[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FunctionalCluster|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
