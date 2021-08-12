<?php

use yii\db\Migration;

/**
 * Class m210812_100433_add_indexes_for_disease
 */
class m210812_100433_add_indexes_for_disease extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('disease_icd_code_and_visible', 'disease', ['icd_code', 'icd_code_visible']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('disease_icd_code_and_visible', 'disease');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210812_100433_add_indexes_for_disease cannot be reverted.\n";

        return false;
    }
    */
}
