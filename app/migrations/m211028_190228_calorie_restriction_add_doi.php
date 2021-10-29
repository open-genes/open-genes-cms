<?php

use yii\db\Migration;

/**
 * Class m211028_190228_calorie_restriction_add_doi
 */
class m211028_190228_calorie_restriction_add_doi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('calorie_restriction_experiment', 'doi', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('calorie_restriction_experiment', 'doi');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211028_190228_calorie_restriction_add_doi cannot be reverted.\n";

        return false;
    }
    */
}
