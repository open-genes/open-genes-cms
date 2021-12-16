<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211202_104330_tissue_specific_promoter_to_purple
 */
class m211202_104330_tissue_specific_promoter_to_purple extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lifespan_experiment', 'tissue_specific_promoter', Schema::TYPE_TEXT . ' DEFAULT NULL AFTER `tissue_specificity`');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('lifespan_experiment', 'tissue_specific_promoter');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211202_104330_tissue_specific_promoter_to_purple cannot be reverted.\n";

        return false;
    }
    */
}
