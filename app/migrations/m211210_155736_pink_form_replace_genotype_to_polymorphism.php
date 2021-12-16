<?php

use yii\db\Migration;

/**
 * Class m211210_155736_pink_form_replace_genotype_to_polymorphism
 */
class m211210_155736_pink_form_replace_genotype_to_polymorphism extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE gene_to_longevity_effect RENAME COLUMN genotype_id TO polymorphism_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('ALTER TABLE gene_to_longevity_effect RENAME COLUMN polymorphism_id TO genotype_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211210_155736_pink_form_replace_genotype_to_polymorphism cannot be reverted.\n";

        return false;
    }
    */
}
