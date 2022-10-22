<?php

use yii\db\Migration;

/**
 * Class m220802_115759_create_table_data_types
 */
class m220802_115759_create_table_data_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%data_types}}', [
            'id' => 'TINYINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
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
        $this->addForeignKey('gene_to_longevity_effect_data_type', 'gene_to_longevity_effect', 'data_type',
            'data_types', 'id', 'RESTRICT');

        //indexes
        $this->createIndex('gene_to_longevity_effect_data_type_idx', 'gene_to_longevity_effect', 'data_type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_longevity_effect_data_type', 'gene_to_longevity_effect');
        $this->dropIndex('gene_to_longevity_effect_data_type_idx', 'gene_to_longevity_effect');
        $this->dropTable('{{%data_types}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220802_115759_create_table_data_types cannot be reverted.\n";

        return false;
    }
    */
}
