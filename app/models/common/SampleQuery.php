<?php

namespace cms\models\common;

/**
 * This is the ActiveQuery class for [[Sample]].
 *
 * @see Sample
 */
class SampleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Sample[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Sample|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
