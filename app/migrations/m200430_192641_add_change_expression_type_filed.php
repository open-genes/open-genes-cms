<?php

use yii\db\Migration;

/**
 * Class m200430_192641_add_change_expression_type_filed
 */
class m200430_192641_add_change_expression_type_filed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('age_related_change', 'measurement_type', \yii\db\Schema::TYPE_TINYINT);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('age_related_change', 'measurement_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200430_192641_add_change_expression_type_filed cannot be reverted.\n";

        return false;
    }
    */
}
