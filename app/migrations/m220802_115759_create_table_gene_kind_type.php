<?php

use yii\db\Migration;

/**
 * Class m220802_115759_create_table_gene_kind_type
 */
class m220802_115759_create_table_gene_kind_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gene_kind_type}}', [
            'id' => $this->primaryKey(),
            'name_en' => $this->string()->null(),
            'name_ru' => $this->string()->null()
        ]);

        $this->insert('gene_kind_type', [
            'name_en' => 'genomic',
            'name_ru' => 'геномные',
        ]);
        $this->insert('gene_kind_type', [
            'name_en' => 'transcriptomic',
            'name_ru' => 'транскриптомные',
        ]);
        $this->insert('gene_kind_type', [
            'name_en' => 'proteomic',
            'name_ru' => 'протеомные',
        ]);

        // foreign keys
        $this->addForeignKey('fk_gtle_gene_id', 'gene_to_longevity_effect', 'gene_id',
            'gene', 'id', 'RESTRICT');

        //indexes
        $this->createIndex('gene_to_longevity_effect_gene_id_idx', 'gene_to_longevity_effect', 'gene_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('gene_to_longevity_effect_gene_id_idx', 'gene_to_longevity_effect');
        $this->dropForeignKey('fk_gtle_gene_id', 'gene_to_longevity_effect');
        $this->dropTable('{{%gene_kind_type}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220802_115759_create_table_gene_kind_type cannot be reverted.\n";

        return false;
    }
    */
}
