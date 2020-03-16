<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Changelog]].
 *
 * @see Changelog
 */
class ChangelogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Changelog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Changelog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
