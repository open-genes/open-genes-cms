<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[LongevityEffect]].
 *
 * @see LongevityEffect
 */
class LongevityEffectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return LongevityEffect[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LongevityEffect|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
