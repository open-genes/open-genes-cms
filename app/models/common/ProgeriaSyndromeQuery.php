<?php

namespace cms\models\common;

/**
 * This is the ActiveQuery class for [[ProgeriaSyndrome]].
 *
 * @see ProgeriaSyndrome
 */
class ProgeriaSyndromeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProgeriaSyndrome[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProgeriaSyndrome|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
