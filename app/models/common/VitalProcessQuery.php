<?php

namespace cms\models\common;

/**
 * This is the ActiveQuery class for [[VitalProcess]].
 *
 * @see VitalProcess
 */
class VitalProcessQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VitalProcess[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VitalProcess|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
