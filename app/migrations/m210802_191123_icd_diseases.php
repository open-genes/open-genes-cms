<?php

use yii\db\Migration;

/**
 * Class m210802_191123_icd_diseases
 */
class m210802_191123_icd_diseases extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('disease', 'icd_code', $this->string(128));
        $this->addColumn('disease', 'parent_icd_code', $this->string(128));
        $this->addColumn('disease', 'icd_name_en', $this->string());
        $this->addColumn('disease', 'icd_name_ru', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('disease', 'icd_code');
        $this->dropColumn('disease', 'parent_icd_code');
        $this->dropColumn('disease', 'icd_name_en');
        $this->dropColumn('disease', 'icd_name_ru');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210802_191123_icd_diseases cannot be reverted.\n";

        return false;
    }
    */
}
