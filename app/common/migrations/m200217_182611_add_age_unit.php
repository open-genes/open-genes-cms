<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200217_182611_add_age_unit
 */
class m200217_182611_add_age_unit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lifespan_experiment', 'age_unit', Schema::TYPE_TINYINT);
        $this->addColumn('gene_intervention_to_vital_process', 'age_unit', Schema::TYPE_TINYINT);
        $this->addColumn('age_related_change', 'age_unit', Schema::TYPE_TINYINT);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('lifespan_experiment', 'age_unit');
        $this->dropColumn('gene_intervention_to_vital_process', 'age_unit');
        $this->dropColumn('age_related_change', 'age_unit');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200217_182611_add_age_unit cannot be reverted.\n";

        return false;
    }
    */
}
