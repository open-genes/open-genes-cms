<?php

namespace cms\models\common;

/**
 * This is the ActiveQuery class for [[AgeRelatedChangeType]].
 *
 * @see AgeRelatedChangeType
 */
class AgeRelatedChangeTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AgeRelatedChangeType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AgeRelatedChangeType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
