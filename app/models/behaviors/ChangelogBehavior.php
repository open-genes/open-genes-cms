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
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
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
                $arChangelog = new Changelog();
                $arChangelog->object_name = (new \ReflectionClass($this->owner))->getShortName();
                $arChangelog->object_id = $this->owner->id;
                $arChangelog->diff = json_encode($changes, JSON_UNESCAPED_UNICODE);
                $this->setUser($arChangelog);
                $arChangelog->time = time();
                $arChangelog->save();
            }
        }
    }

    public function afterDelete($event)
    {
        $arChangelog = new Changelog();
        $arChangelog->object_name = (new \ReflectionClass($event->sender))->getShortName();
        $arChangelog->object_id = $event->sender->id;
        $arChangelog->diff = json_encode(['deleted'], JSON_UNESCAPED_UNICODE);
        $this->setUser($arChangelog);
        $arChangelog->time = time();
        $arChangelog->save();
    }
    
    private function setUser(&$arChangelog)
    {
        if (isset(\Yii::$app->user)) {
            $arChangelog->user_id = \Yii::$app->user->id;
            $arChangelog->user_login = \Yii::$app->user->identity->username;
        } elseif (\Yii::$app instanceof \yii\console\Application) {
            $arChangelog->user_id = 0;
            $arChangelog->user_login = 'cli';
        }
    }
}