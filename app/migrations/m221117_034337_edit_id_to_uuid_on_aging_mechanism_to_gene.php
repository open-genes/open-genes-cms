<?php

use yii\db\Migration;

/**
 * Class m221117_034337_edit_id_to_uuid_on_aging_mechanism_to_gene
 */
class m221117_034337_edit_id_to_uuid_on_aging_mechanism_to_gene extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('DELETE FROM aging_mechanism_to_gene');
        $this->execute('ALTER TABLE aging_mechanism_to_gene DROP COLUMN id;');
        $this->execute('ALTER TABLE aging_mechanism_to_gene ADD uuid VARCHAR(38) NOT NULL PRIMARY KEY;');
        $this->createIndex('aging_mechanism_to_gene_uuid_idx', '{{%aging_mechanism_to_gene}}', 'uuid', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DELETE FROM aging_mechanism_to_gene');
        $this->execute('ALTER TABLE aging_mechanism_to_gene DROP COLUMN uuid;');
        $this->execute('ALTER TABLE aging_mechanism_to_gene ADD id INTEGER NOT NULL PRIMARY KEY;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221117_034337_edit_id_to_uuid_on_aging_mechanism_to_gene cannot be reverted.\n";

        return false;
    }
    */
}
