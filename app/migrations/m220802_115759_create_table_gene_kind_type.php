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
        $this->createTable('{{%data_types}}', [
            'id' => $this->primaryKey(),
            'name_en' => $this->string()->null(),
            'name_ru' => $this->string()->null()
        ]);

        $this->insert('data_types', [
            'name_en' => 'genomic',
            'name_ru' => 'геномные',
        ]);
        $this->insert('data_types', [
            'name_en' => 'transcriptomic',
            'name_ru' => 'транскриптомные',
        ]);
        $this->insert('data_types', [
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
        $this->dropTable('{{%data_types}}');
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
