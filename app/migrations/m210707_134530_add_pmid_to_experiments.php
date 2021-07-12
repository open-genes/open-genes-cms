<?php

use yii\db\Migration;

/**
 * Class m210707_134530_add_pmid_to_experiments
 */
class m210707_134530_add_pmid_to_experiments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene_to_additional_evidence', 'pmid', $this->string());
        $this->addColumn('age_related_change', 'pmid', $this->string());
        $this->addColumn('gene_intervention_to_vital_process', 'pmid', $this->string());
        $this->addColumn('gene_to_progeria', 'pmid', $this->string());
        $this->addColumn('lifespan_experiment', 'pmid', $this->string());
        $this->addColumn('protein_to_gene', 'pmid', $this->string());
        $this->addColumn('gene_to_longevity_effect', 'pmid', $this->string());
        $this->addColumn('gene_to_disease', 'pmid', $this->string());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene_to_additional_evidence', 'pmid');
        $this->dropColumn('age_related_change', 'pmid');
        $this->dropColumn('gene_intervention_to_vital_process', 'pmid');
        $this->dropColumn('gene_to_progeria', 'pmid');
        $this->dropColumn('lifespan_experiment', 'pmid');
        $this->dropColumn('protein_to_gene', 'pmid');
        $this->dropColumn('gene_to_longevity_effect', 'pmid');
        $this->dropColumn('gene_to_disease', 'pmid');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210707_134530_add_pmid_to_experiments cannot be reverted.\n";

        return false;
    }
    */
}
