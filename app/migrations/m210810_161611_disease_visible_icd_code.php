<?php

use yii\db\Migration;

/**
 * Class m210810_161611_disease_visible_icd_code
 */
class m210810_161611_disease_visible_icd_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('disease', 'icd_code_visible', $this->string(128));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('disease', 'icd_code_visible');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210810_161611_disease_visible_icd_code cannot be reverted.\n";

        return false;
    }
    */
}
