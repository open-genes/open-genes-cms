<?php

use yii\db\Migration;

/**
 * Class m200607_143226_add_genotype_and_allele_polymorphism
 */
class m200607_143226_add_genotype_and_allele_polymorphism extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        
        $this->addColumn('lifespan_experiment', 'genotype', \yii\db\Schema::TYPE_TINYINT);
        $this->addColumn('gene_intervention_to_vital_process', 'genotype', \yii\db\Schema::TYPE_TINYINT);
        $this->addColumn('gene_to_longevity_effect', 'allele_variant', \yii\db\Schema::TYPE_STRING);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('lifespan_experiment', 'genotype');
        $this->dropColumn('gene_intervention_to_vital_process', 'genotype');
        $this->dropColumn('gene_to_longevity_effect', 'allele_variant');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200607_143226_add_genotype_and_allele_polymorphism cannot be reverted.\n";

        return false;
    }
    */
}
