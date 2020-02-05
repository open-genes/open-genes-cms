<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[GeneLongevityAssociationType]].
 *
 * @see GeneLongevityAssociationType
 */
class GeneLongevityAssociationTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GeneLongevityAssociationType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GeneLongevityAssociationType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
