<?php

use yii\db\Migration;

/**
 * Class m200216_081940_contributor_role
 */
class m200216_081940_contributor_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $contributor = $auth->createRole('contributor');
        $auth->add($contributor);

        $editor = $auth->getRole('editor');
        $auth->addChild($editor, $contributor);

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
        echo "m200216_081940_contributor_role cannot be reverted.\n";

        return false;
    }
    */
}
