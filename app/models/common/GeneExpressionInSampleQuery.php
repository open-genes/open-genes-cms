<?php

namespace app\models\common;

/**
 * This is the ActiveQuery class for [[GeneExpressionInSample]].
 *
 * @see GeneExpressionInSample
 */
class GeneExpressionInSampleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneExpressionInSample[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneExpressionInSample|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
