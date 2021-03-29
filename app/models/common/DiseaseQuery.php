<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[Disease]].
 *
 * @see Disease
 */
class DiseaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Disease[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Disease|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
