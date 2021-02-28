<?php

namespace cms\models\common;

/**
 * This is the ActiveQuery class for [[CommentCause]].
 *
 * @see CommentCause
 */
class CommentCauseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CommentCause[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CommentCause|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
