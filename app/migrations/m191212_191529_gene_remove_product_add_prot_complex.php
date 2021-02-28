<?php

use yii\db\Migration;
use yii\db\sqlite\Schema;

/**
 * Class m191212_191529_gene_remove_product_add_prot_complex
 */
class m191212_191529_gene_remove_product_add_prot_complex extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('gene', 'product_ru');
        $this->dropColumn('gene', 'product_en');

        $this->addColumn('gene', 'protein_complex_ru', Schema::TYPE_TEXT);
        $this->addColumn('gene', 'protein_complex_en', Schema::TYPE_TEXT);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene', 'protein_complex_en');
        $this->dropColumn('gene', 'protein_complex_ru');

        $this->addColumn('gene', 'product_en', Schema::TYPE_STRING);
        $this->addColumn('gene', 'product_ru', Schema::TYPE_STRING);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191212_191529_gene_remove_product_add_prot_complex cannot be reverted.\n";

        return false;
    }
    */
}
