<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191118_190825_gene_product_en
 */
class m191118_190825_gene_product_en extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene', 'product_en', Schema::TYPE_STRING);
        $this->renameColumn('gene', 'product', 'product_ru');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene', 'product_en');
        $this->renameColumn('gene', 'product_ru', 'product');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191118_190825_gene_product_en cannot be reverted.\n";

        return false;
    }
    */
}
