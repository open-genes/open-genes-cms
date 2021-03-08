<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200414_175408_percents_to_float
 */
class m200414_175408_percents_to_float extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('age_related_change', 'change_value_male', Schema::TYPE_FLOAT);
        $this->alterColumn('age_related_change', 'change_value_female', Schema::TYPE_FLOAT);
        $this->alterColumn('age_related_change', 'change_value_common', Schema::TYPE_FLOAT);
        $this->alterColumn('age_related_change', 'age_from', Schema::TYPE_FLOAT);
        $this->alterColumn('age_related_change', 'age_to', Schema::TYPE_FLOAT);
        
        $this->alterColumn('lifespan_experiment', 'lifespan_change_percent_male', Schema::TYPE_FLOAT);
        $this->alterColumn('lifespan_experiment', 'lifespan_change_percent_female', Schema::TYPE_FLOAT);
        $this->alterColumn('lifespan_experiment', 'lifespan_change_percent_common', Schema::TYPE_FLOAT);
        $this->alterColumn('lifespan_experiment', 'age', Schema::TYPE_FLOAT);
        
        $this->alterColumn('gene_intervention_to_vital_process', 'age', Schema::TYPE_FLOAT);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200414_175408_percents_to_float cannot be reverted.\n";

        return false;
    }
    */
}
