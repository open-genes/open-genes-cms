<?php

use yii\db\Migration;

/**
 * Class m211020_104906_add_column_mutation_induction
 */
class m211020_104906_add_column_mutation_induction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lifespan_experiment', 'mutation_induction', $this->tinyInteger(1)
            ->after('tissue_specificity')
            ->defaultValue(0)
            ->comment('Индукция мутации отменой препарата'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('lifespan_experiment', 'mutation_induction');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211020_104906_add_column_mutation_induction cannot be reverted.\n";

        return false;
    }
    */
}
