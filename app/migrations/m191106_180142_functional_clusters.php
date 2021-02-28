<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191106_180142_functional_clusters
 */
class m191106_180142_functional_clusters extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('functional_cluster', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_to_functional_cluster', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'functional_cluster_id' => Schema::TYPE_INTEGER
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('gene_to_functional_cluster_gene', 'gene_to_functional_cluster', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_functional_cluster_functional_cluster', 'gene_to_functional_cluster', 'functional_cluster_id', 'functional_cluster', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_functional_cluster_gene', 'gene_to_functional_cluster');
        $this->dropForeignKey('gene_to_functional_cluster_functional_cluster', 'gene_to_functional_cluster');
        $this->dropTable('gene_to_functional_cluster');
        $this->dropTable('functional_cluster');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191106_180142_functional_clusters cannot be reverted.\n";

        return false;
    }
    */
}
