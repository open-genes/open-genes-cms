<?php

use yii\db\Migration;

/**
 * Class m220805_130922_drop_columns_to_gene
 */
class m220805_130922_drop_columns_to_gene extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('gene', 'commentCause');
        $this->dropColumn('gene', 'commentsReferenceLinks');
        $this->dropColumn('gene', 'rating');
        $this->dropColumn('gene', 'why');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('gene', 'why', $this->string(1000)->null());
        $this->addColumn('gene', 'rating', $this->integer()->null());
        $this->addColumn('gene', 'commentsReferenceLinks', $this->text()->null());
        $this->addColumn('gene', 'commentCause', $this->text()->null());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220805_130922_drop_columns_to_gene cannot be reverted.\n";

        return false;
    }
    */
}
