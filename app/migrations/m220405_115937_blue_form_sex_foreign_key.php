<?php

use yii\db\Migration;

/**
 * Class m220405_115937_blue_form_sex_foreign_key
 */
class m220405_115937_blue_form_sex_foreign_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('age_related_change_sex', 'age_related_change', 'sex', 'organism_sex', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('age_related_change_sex', 'age_related_change');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220405_115937_blue_form_sex_foreign_key cannot be reverted.\n";

        return false;
    }
    */
}
