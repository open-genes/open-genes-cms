<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "User".
 * @todo временные костыли под управление юзерами, пока что все здесь в AR
 */
class User extends common\User
{

    public $newPassword;
    public $roles;
    public $recentlyActivated = false;

    private static $statuses = [
        self::STATUS_ACTIVE => 'активный',
        self::STATUS_INACTIVE => 'неактивный',
        self::STATUS_DELETED => 'Х удален',
    ];

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['newPassword', 'roles', 'username'], 'safe'],
            [['email'], 'email'],
            [['username', 'email'], 'unique'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'username' => Yii::t('common', 'Login'),
            'newPassword' => Yii::t('common', 'New password'),
        ]);
    }

    public function getStatusName()
    {
        return self::$statuses[$this->status];
    }

    public function getRolesArray()
    {
        $rolesNames = [];
        $auth = \Yii::$app->authManager;
        $roles = $auth->getRolesByUser($this->getId());
        foreach ($roles as $role) {
            $rolesNames[$role->name] = $role->name;
        }
        return $rolesNames;
    }

    public static function getAllRolesArray()
    {
        $result = [];
        $allRoles = \Yii::$app->authManager->getRoles();
        foreach ($allRoles as $role) {
            $result[$role->name] = $role->name;
        }
        return $result;
    }
    public function beforeSave($insert)
    {
        if($this->newPassword) {
            $this->setPassword($this->newPassword);
        }
        if($this->isNewRecord) {
            $this->generateAuthKey();
        }
        $this->status = (int)$this->status;
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($this->roles) {
            $auth = \Yii::$app->authManager;
            $oldRoles = $auth->getRolesByUser($this->getId());
            foreach ($oldRoles as $oldRole) {
                $auth->revoke($oldRole, $this->getId());
            }
            foreach ($this->roles as $role) {
                $newRole = $auth->getRole($role);
                $auth->assign($newRole, $this->getId());
            }
        }
        if(isset($changedAttributes['status']) && $this->status == self::STATUS_ACTIVE) {
            $this->recentlyActivated = true;
        }
        return parent::afterSave($insert, $changedAttributes);
    }


}
