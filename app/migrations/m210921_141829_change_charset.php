<?php

use yii\db\Migration;

/**
 * Class m210921_141829_change_charset
 */
class m210921_141829_change_charset extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE gene_to_ontology CHARACTER SET utf8 COLLATE utf8_general_ci');
        $this->execute('ALTER TABLE gene_ontology CHARACTER SET utf8 COLLATE utf8_general_ci');
        $this->alterColumn('gene_ontology', 'name_ru', $this->string()->append('CHARACTER SET utf8 COLLATE utf8_general_ci'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('ALTER TABLE gene_to_ontology CHARACTER SET latin1 COLLATE latin1_swedish_ci');
        $this->execute('ALTER TABLE gene_ontology CHARACTER SET latin1 COLLATE latin1_swedish_ci');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210921_141829_change_charset cannot be reverted.\n";

        return false;
    }
    */
}
