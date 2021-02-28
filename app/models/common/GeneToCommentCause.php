<?php

namespace cms\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_comment_cause".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $comment_cause_id
 *
 * @property CommentCause $commentCause
 * @property Gene $gene
 */
class GeneToCommentCause extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_comment_cause';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'comment_cause_id'], 'integer'],
            [['comment_cause_id'], 'exist', 'skipOnError' => true, 'targetClass' => CommentCause::class, 'targetAttribute' => ['comment_cause_id' => 'id']],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gene_id' => 'Gene ID',
            'comment_cause_id' => 'Comment Cause ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentCause()
    {
        return $this->hasOne(CommentCause::className(), ['id' => 'comment_cause_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['id' => 'gene_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneToCommentCauseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToCommentCauseQuery(get_called_class());
    }
}
