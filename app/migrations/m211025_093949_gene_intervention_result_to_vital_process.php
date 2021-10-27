<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211025_093949_gene_intervention_result_to_vital_process
 */
class m211025_093949_gene_intervention_result_to_vital_process extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('gene_intervention_result_to_vital_process', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'intervention_result_for_vital_process_id' => Schema::TYPE_INTEGER,
            'vital_process_id' => Schema::TYPE_INTEGER,
        ]);

        $this->addForeignKey('interv_result_to_vital_pr_to_gene', 'gene_intervention_result_to_vital_process', 'gene_id', 'gene_intervention_to_vital_process', 'gene_id');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_result', 'gene_intervention_result_to_vital_process', 'intervention_result_for_vital_process_id', 'intervention_result_for_vital_process', 'id');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_process', 'gene_intervention_result_to_vital_process', 'vital_process_id', 'vital_process', 'id');

        $data = Yii::$app->db->createCommand('SELECT gene_id, intervention_result_for_vital_process_id, vital_process_id from gene_intervention_to_vital_process')->queryAll();
        $dataToInsert = [];
        foreach ($data as $row) {
            $dataToInsert[] = array_values($row);
        }

        $this->batchInsert(
            'gene_intervention_result_to_vital_process',
            ['gene_id', 'intervention_result_for_vital_process_id', 'vital_process_id'],
            $dataToInsert
        );

        $this->dropForeignKey('interv_to_vital_pr_interv_res', 'gene_intervention_to_vital_process');
        $this->dropForeignKey('interv_to_vital_pr_vital_process', 'gene_intervention_to_vital_process');

        $this->dropColumn('gene_intervention_to_vital_process', 'intervention_result_for_vital_process_id');
        $this->dropColumn('gene_intervention_to_vital_process', 'vital_process_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('interv_result_to_vital_pr_to_gene', 'gene_intervention_result_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_result', 'gene_intervention_result_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_process', 'gene_intervention_result_to_vital_process');
        $this->dropTable('gene_intervention_result_to_vital_process');

        $this->addColumn('gene_intervention_to_vital_process', 'intervention_result_for_vital_process_id', Schema::TYPE_INTEGER);
        $this->addColumn('gene_intervention_to_vital_process', 'vital_process_id', Schema::TYPE_INTEGER);

        $this->addForeignKey('interv_to_vital_pr_interv_res', 'gene_intervention_to_vital_process', 'intervention_result_for_vital_process_id','intervention_result_for_vital_process', 'id');
        $this->addForeignKey('interv_to_vital_pr_vital_process', 'gene_intervention_to_vital_process', 'vital_process_id','vital_process', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211025_093949_gene_intervention_result_to_vital_process cannot be reverted.\n";

        return false;
    }
    */
}
