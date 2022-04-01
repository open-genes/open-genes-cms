<?php

use yii\db\Migration;

/**
 * Class m220331_150355_blue_form_rename
 */
class m220331_150355_blue_form_rename extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('age_related_change', 'measurement_type', 'expression_evaluation_by_id');
        $this->renameColumn('general_lifespan_experiment', 'measurement_type','expression_evaluation_by_id');

        $this->addColumn('age_related_change', 'measurement_type_id', \yii\db\Schema::TYPE_INTEGER);
        $this->renameTable('measurement_type', 'expression_evaluation');

        $this->createTable('measurement_type', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->batchInsert('measurement_type', ['id', 'name_ru', 'name_en'], [
            [1, 'RT-PCR', 'RT-PCR'],
            [2, 'Microarray', 'Microarray'],
            [3, 'Western blot', 'Western blot'],
            [4, 'Northern blot', 'Northern blot'],
            [5, 'immunohistochemistry', 'immunohistochemistry'],
            [6, 'meta-analysis', 'meta-analysis'],
        ]);

        $this->alterColumn('age_related_change', 'expression_evaluation_by_id', $this->integer());
        $this->alterColumn('general_lifespan_experiment', 'expression_evaluation_by_id', $this->integer());

        $this->addForeignKey('age_related_change_expression_evaluation', 'age_related_change', 'expression_evaluation_by_id', 'expression_evaluation', 'id', 'CASCADE');
        $this->addForeignKey('general_le_expression_evaluation', 'general_lifespan_experiment', 'expression_evaluation_by_id', 'expression_evaluation', 'id', 'CASCADE');
        $this->addForeignKey('age_related_change_measurement_type', 'age_related_change', 'measurement_type_id', 'measurement_type', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('age_related_change_measurement_type', 'age_related_change');
        $this->dropForeignKey('general_le_expression_evaluation', 'general_lifespan_experiment');
        $this->dropForeignKey('age_related_change_expression_evaluation', 'age_related_change');

        $this->dropTable('measurement_type');
        $this->renameTable('expression_evaluation', 'measurement_type');
        $this->dropColumn('age_related_change', 'measurement_type_id');

        $this->renameColumn('general_lifespan_experiment', 'expression_evaluation_by_id','measurement_type');
        $this->renameColumn('age_related_change', 'expression_evaluation_by_id', 'measurement_type');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220331_150355_blue_form_rename cannot be reverted.\n";

        return false;
    }
    */
}
