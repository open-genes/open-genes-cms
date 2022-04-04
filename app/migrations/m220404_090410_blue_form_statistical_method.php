<?php

use yii\db\Migration;

/**
 * Class m220404_090410_blue_form_statistical_method
 */
class m220404_090410_blue_form_statistical_method extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('age_related_change', 'statistical_method_id', \yii\db\Schema::TYPE_INTEGER);
        $this->createTable('statistical_method', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->insert(
            'statistical_method', [
                'name_en' => 'linear regression',
                'name_ru' => 'linear regression'
            ]
        );

        $this->addForeignKey('age_related_change_statistical_method', 'age_related_change', 'statistical_method_id', 'statistical_method', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('age_related_change_statistical_method', 'age_related_change');
        $this->dropTable('statistical_method');
        $this->dropColumn('age_related_change', 'statistical_method_id');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220404_090410_blue_form_statistical_method cannot be reverted.\n";

        return false;
    }
    */
}
