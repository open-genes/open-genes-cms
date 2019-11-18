<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[GeneToFunction]].
 *
 * @see GeneToFunction
 */
class GeneToFunctionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneToFunction[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneToFunction|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
