<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211012_100516_create_gene_sources
 */
class m211012_100516_create_gene_sources extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('source', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_to_source', [
            'gene_id' => Schema::TYPE_INTEGER,
            'source_id' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createIndex('gene_id', 'gene_to_source', ['gene_id']);
        $this->createIndex('source_id', 'gene_to_source', ['gene_id']);

        $this->addForeignKey('gene_to_source', 'gene_to_source', 'gene_id', 'gene', 'id');
        $this->addForeignKey('source_to_gene', 'gene_to_source', 'source_id', 'source', 'id');

        $this->batchInsert('source', ['name'], [
            ['GeneAge'],
            ['ABDB'],
            ['Horvath'],
        ]);

        $this->addRelationToHorvath();

        $this->dropColumn('gene', 'source');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_source', 'gene');
        $this->dropForeignKey('source_to_gene', 'source');
        $this->dropTable('source');
        $this->dropTable('gene_to_source');
        $this->addColumn('gene', 'source', Schema::TYPE_TEXT);
    }

    private function addRelationToHorvath()
    {
        $rows = Yii::$app->db->createCommand('SELECT id from gene where methylation_horvath is not null')->queryAll();
        if (empty($rows) || !is_array($rows)) {
            return;
        }
        $match = [];
        foreach ($rows as $key => $value) {
            $match[] = [$value['id'], 3];
        }
        $this->batchInsert('gene_to_source', ['gene_id', 'source_id'], $match);
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211012_100516_create_gene_sources cannot be reverted.\n";

        return false;
    }
    */
}
