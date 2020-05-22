<?php

use yii\db\Migration;

/**
 * Class m200501_172411_add_ensg_for_gene
 */
class m200501_172411_add_ensg_for_gene extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene', 'ensembl', \yii\db\Schema::TYPE_STRING);
        $this->addColumn('gene', 'human_protein_atlas', \yii\db\Schema::TYPE_TEXT);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene', 'ensembl');
        $this->dropColumn('gene', 'human_protein_atlas');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200501_172410_expression_change_to_int cannot be reverted.\n";

        return false;
    }
    */
}
