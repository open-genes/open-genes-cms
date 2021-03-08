<?php
namespace app\models\behaviors;

use app\models\Changelog;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class ChangelogBehavior extends Behavior
{
    private static $skipAttributes = [
        'created_at', 'updated_at', 'id'
    ];
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }

    public function afterSave($event)
    {
        if($event->changedAttributes) {
            $changes = [];
            foreach ($event->changedAttributes as $attribute => $oldValue) {
                $newValue = $this->owner->attributes[$attribute];
                if($newValue != $oldValue && !in_array($attribute, self::$skipAttributes)) {
                    $changes[$attribute] = ['old' => $oldValue, 'new' => $this->owner->attributes[$attribute]];
                }
            }
            if($changes) {
                $arChengelog = new Changelog();
                $arChengelog->object_name = (new \ReflectionClass($this->owner))->getShortName();
                $arChengelog->object_id = $this->owner->id;
                $arChengelog->diff = json_encode($changes, JSON_UNESCAPED_UNICODE);
                $arChengelog->user_id = \Yii::$app->user->id;
                $arChengelog->user_login = \Yii::$app->user->identity->username;
                $arChengelog->time = time();
                $arChengelog->save();
            }
        }
    }
}