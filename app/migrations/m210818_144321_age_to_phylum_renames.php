<?php

use yii\db\Migration;

/**
 * Class m210818_144321_age_to_phylum_renames
 */
class m210818_144321_age_to_phylum_renames extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('age', 'phylum');

        $this->renameColumn('gene', 'age_id', 'family_phylum_id');

        $this->addColumn('gene', 'phylum_id', $this->integer());
        $this->addForeignKey('gene_phylum', 'gene', 'phylum_id', 'phylum', 'id');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {   
        $this->dropForeignKey('gene_phylum', 'gene');
        $this->dropColumn('gene', 'phylum_id');
        echo "m210818_144321_age_to_phylum_renames cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210818_144321_age_to_phylum_renames cannot be reverted.\n";

        return false;
    }
    */
}
