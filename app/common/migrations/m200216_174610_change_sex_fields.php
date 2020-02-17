<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200216_174610_change_sex_fields
 */
class m200216_174610_change_sex_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lifespan_experiment', 'lifespan_change_percent_male', Schema::TYPE_INTEGER);
        $this->addColumn('lifespan_experiment', 'lifespan_change_percent_female', Schema::TYPE_INTEGER);
        $this->addColumn('lifespan_experiment', 'lifespan_change_percent_common', Schema::TYPE_INTEGER);

        $this->dropColumn('lifespan_experiment', 'lifespan_change_percent');
        $this->dropColumn('lifespan_experiment', 'sex_of_organism');

        $this->addColumn('age_related_change', 'change_value_male', Schema::TYPE_INTEGER);
        $this->addColumn('age_related_change', 'change_value_female', Schema::TYPE_INTEGER);
        $this->addColumn('age_related_change', 'change_value_common', Schema::TYPE_INTEGER);

        $this->dropColumn('age_related_change', 'change_value');
        $this->dropColumn('age_related_change', 'sex_of_organism');

        $this->dropColumn('gene_intervention_to_vital_process', 'lifespan_change_percent');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('lifespan_experiment', 'lifespan_change_percent_male');
        $this->dropColumn('lifespan_experiment', 'lifespan_change_percent_female');
        $this->dropColumn('lifespan_experiment', 'lifespan_change_percent_common');

        $this->addColumn('lifespan_experiment', 'lifespan_change_percent', Schema::TYPE_INTEGER);
        $this->addColumn('lifespan_experiment', 'sex_of_organism', Schema::TYPE_INTEGER);

        $this->dropColumn('age_related_change', 'change_value_male');
        $this->dropColumn('age_related_change', 'change_value_female');
        $this->dropColumn('age_related_change', 'change_value_common');

        $this->addColumn('age_related_change', 'change_value', Schema::TYPE_INTEGER);
        $this->addColumn('age_related_change', 'sex_of_organism', Schema::TYPE_INTEGER);

        $this->addColumn('gene_intervention_to_vital_process', 'lifespan_change_percent', Schema::TYPE_INTEGER);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200216_174610_change_sex_fields cannot be reverted.\n";

        return false;
    }
    */
}
