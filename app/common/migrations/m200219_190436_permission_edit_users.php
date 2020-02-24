<?php

use yii\db\Migration;

/**
 * Class m200219_190436_permission_edit_users
 */
class m200219_190436_permission_edit_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $controlUsers = $auth->createPermission('controlUsers');
        $controlUsers->description = 'Control users and their permissions';
        $auth->add($controlUsers);

        $manager = $auth->createRole('manager');
        $auth->add($manager);

        $admin = $auth->getRole('admin');

        $auth->addChild($manager, $controlUsers);
        $auth->addChild($admin, $manager);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200219_190436_permission_edit_users cannot be reverted.\n";

        return false;
    }
    */
}
