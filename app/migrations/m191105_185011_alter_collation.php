<?php

use yii\db\Migration;

/**
 * Class m191105_185011_alter_collation
 */
class m191105_185011_alter_collation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER DATABASE open_genes CHARACTER SET utf8 COLLATE utf8_general_ci');
        $this->execute('ALTER TABLE gene CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci');
        $this->execute('ALTER TABLE sample CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci');
        $this->execute('ALTER TABLE gene_expression_in_sample CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191105_185011_alter_collation cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191105_185011_alter_collation cannot be reverted.\n";

        return false;
    }
    */
}
