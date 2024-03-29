<?php

use app\models\common\AgingMechanism;
use app\models\common\Gene;
use yii\db\Migration;

/**
 * Class m221026_142538_create_association_table_for_gene_and_mechanism
 */
class m221026_142538_create_association_table_for_gene_and_mechanism extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%aging_mechanism_to_gene}}', [
            'id' => $this->primaryKey(),
            'aging_mechanism_id' => $this->integer()->notNull(),
            'gene_id' => $this->integer()->notNull(),
        ]);

        // foreign keys
        $this->addForeignKey('fk_amtg_gene_id', 'aging_mechanism_to_gene', 'gene_id',
            'gene', 'id', 'RESTRICT');
        $this->addForeignKey('fk_amtg_aging_mechanism_id', 'aging_mechanism_to_gene', 'aging_mechanism_id',
            'aging_mechanism', 'id', 'RESTRICT');

        $this->execute('ALTER TABLE aging_mechanism_to_gene ADD CONSTRAINT uniq_aging_mechanism_id_and_gene_id UNIQUE (gene_id, aging_mechanism_id);');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%aging_mechanism_to_gene}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221026_142538_create_association_table_for_gene_and_mechanism cannot be reverted.\n";

        return false;
    }
    */
}
