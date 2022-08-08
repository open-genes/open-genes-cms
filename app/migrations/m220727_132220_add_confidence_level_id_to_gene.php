<?php

use yii\db\Migration;

/**
 * Class m220727_132220_add_confidence_level_id_to_gene
 */
class m220727_132220_add_confidence_level_id_to_gene extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene', 'confidence_level_id', $this->integer()->null());

        // foreign keys
        $this->addForeignKey('fk_confidence_level_id', 'gene', 'confidence_level_id',
            'confidence_level', 'id', 'RESTRICT');

        //indexes
        $this->createIndex('confidence_level_id_idx', 'gene', 'confidence_level_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene', 'confidence_level_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220727_132220_add_confidence_level_id_to_gene cannot be reverted.\n";

        return false;
    }
    */
}
