<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "changelog".
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_login
 * @property string $object_name
 * @property int $object_id
 * @property string $diff
 * @property int $time
 */
class Changelog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'changelog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'object_id', 'time'], 'integer'],
            [['diff'], 'string'],
            [['user_login', 'object_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user_login' => 'User Login',
            'object_name' => 'Object Name',
            'object_id' => 'Object ID',
            'diff' => 'Diff',
            'time' => 'Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ChangelogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChangelogQuery(get_called_class());
    }
}
