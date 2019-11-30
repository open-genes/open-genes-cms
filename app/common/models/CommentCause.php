<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment_cause".
 *
 * @property int $id
 * @property string $name_en
 * @property string $name_ru
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GeneToCommentCause[] $geneToCommentCauses
 */
class CommentCause extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment_cause';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name_en', 'name_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_en' => 'Name En',
            'name_ru' => 'Name Ru',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneToCommentCauses()
    {
        return $this->hasMany(GeneToCommentCause::className(), ['comment_cause_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CommentCauseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentCauseQuery(get_called_class());
    }
}
