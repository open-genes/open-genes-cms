<?php

use yii\db\Migration;

/**
 * Class m191104_172319_rbac
 */
class m191104_172319_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $editGene = $auth->createPermission('editGene');
        $editGene->description = 'Edit a gene information';
        $auth->add($editGene);

        $editor = $auth->createRole('editor');
        $auth->add($editor);
        $auth->addChild($editor, $editGene);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $editor);

        $auth->assign($editor, 2);
        $auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191104_172319_rbac cannot be reverted.\n";

        return false;
    }
    */
}
