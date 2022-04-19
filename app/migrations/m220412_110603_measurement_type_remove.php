<?php

use yii\db\Migration;

/**
 * Class m220412_110603_measurement_type_remove
 */
class m220412_110603_measurement_type_remove extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('calorie_restr_measurement_method', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_measurement_type', 'calorie_restriction_experiment');

        $this->dropTable('measurement_method');
        $this->renameTable('measurement_type', 'measurement_method');

        $this->addForeignKey('calorie_restr_measurement_method', 'calorie_restriction_experiment', 'measurement_method_id', 'measurement_method', 'id', 'CASCADE');
        $this->addForeignKey('calorie_restr_expression_evaluation', 'calorie_restriction_experiment', 'expression_evaluation_by_id', 'expression_evaluation', 'id', 'CASCADE');

        $this->renameColumn('age_related_change', 'measurement_type_id', 'measurement_method_id');
        $this->dropForeignKey('age_related_change_measurement_type', 'age_related_change');
        $this->addForeignKey('age_related_change_measurement_method', 'age_related_change', 'measurement_method_id', 'measurement_method', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('age_related_change_measurement_method', 'age_related_change');
        $this->renameColumn('age_related_change', 'measurement_method_id', 'measurement_type_id');
        $this->addForeignKey('age_related_change_measurement_type', 'age_related_change', 'measurement_type_id', 'measurement_method', 'id');

        $this->dropForeignKey('calorie_restr_expression_evaluation', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_measurement_method', 'calorie_restriction_experiment');

        $this->renameTable('measurement_method', 'measurement_type');
        $this->createTable('measurement_method', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('calorie_restr_measurement_type', 'calorie_restriction_experiment', 'expression_evaluation_by_id', 'expression_evaluation', 'id');
        $this->addForeignKey('calorie_restr_measurement_method', 'calorie_restriction_experiment', 'measurement_method_id', 'measurement_method', 'id');




    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220412_110603_measurement_type_remove cannot be reverted.\n";

        return false;
    }
    */
}
