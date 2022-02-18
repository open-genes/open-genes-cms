<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220218_210705_gene_location_on_chromosome
 */
class m220218_210705_gene_location_on_chromosome extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('worker_state', [
            'name' => Schema::TYPE_STRING,
            'state' => Schema::TYPE_STRING,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createIndex('uin_worker_state', 'worker_state', 'name', true);

        $this->addColumn('gene', 'hgnc_id', Schema::TYPE_STRING);

        $this->createTable('gene_locus_group', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->createIndex('uin_gene_locus_group_name', 'gene_locus_group', 'name', true);

        $this->addColumn('gene', 'locus_group', Schema::TYPE_INTEGER);

        $this->createTable('gene_group', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->createIndex('uin_gene_group_name', 'gene_group', 'name', true);

        $this->addColumn('gene', 'gene_group', Schema::TYPE_INTEGER);

        $this->createTable('gene_transcript', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'acc_version' => $this->text()->notNull(),
            'name' => $this->text()->notNull(),
            'length' => Schema::TYPE_INTEGER,
            'genomic_range_acc_version' => $this->text()->notNull(),
            'genomic_range_begin' => Schema::TYPE_INTEGER,
            'genomic_range_end' => Schema::TYPE_INTEGER,
            'genomic_range_orientation' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->createIndex('in_gene_transcript_gene_id', 'gene_transcript', 'gene_id');
        $this->addForeignKey('gene_to_gene_transcript', 'gene_transcript', 'gene_id', 'gene', 'id', 'CASCADE');

        $this->createTable('transcript_exon', [
            'id' => Schema::TYPE_PK,
            'transcript_id' => Schema::TYPE_INTEGER,
            'begin' => Schema::TYPE_INTEGER,
            'end' => Schema::TYPE_INTEGER,
            'ord' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createIndex('in_transcript_exon_transcript_id', 'gene_transcript', 'id');
        $this->addForeignKey('transcript_exon_to_gene_transcript', 'transcript_exon', 'transcript_id', 'gene_transcript', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('transcript_exon_to_gene_transcript', 'transcript_exon');
        $this->dropIndex('in_transcript_exon_transcript_id', 'gene_transcript');
        $this->dropTable('transcript_exon');
        $this->dropForeignKey('gene_to_gene_transcript', 'gene_transcript');
        $this->dropIndex('in_gene_transcript_gene_id', 'gene_transcript');
        $this->dropTable('gene_transcript');
        $this->dropColumn('gene', 'gene_group');
        $this->dropIndex('uin_gene_group_name', 'gene_group');
        $this->dropTable('gene_group');
        $this->dropColumn('gene', 'locus_group');
        $this->dropIndex('uin_gene_locus_group_name', 'gene_locus_group');
        $this->dropTable('gene_locus_group');
        $this->dropColumn('gene', 'hgnc_id');
        $this->dropIndex('uin_worker_state', 'worker_state');
        $this->dropTable('worker_state');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220218_210705_gene_location_on_chromosome cannot be reverted.\n";

        return false;
    }
    */
}
