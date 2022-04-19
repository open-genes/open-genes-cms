<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220331_141021_blue_form_min_max_age
 */
class m220331_141021_blue_form_min_max_age extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('age_related_change', 'min_age_of_controls', Schema::TYPE_FLOAT);
        $this->addColumn('age_related_change', 'max_age_of_controls', Schema::TYPE_FLOAT);
        $this->addColumn('age_related_change', 'min_age_of_experiment', Schema::TYPE_FLOAT);
        $this->addColumn('age_related_change', 'max_age_of_experiment', Schema::TYPE_FLOAT);

        $this->addColumn('age_related_change', 'n_of_controls', Schema::TYPE_FLOAT);
        $this->addColumn('age_related_change', 'n_of_experiment', Schema::TYPE_FLOAT);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('age_related_change', 'min_age_of_controls');
        $this->dropColumn('age_related_change', 'max_age_of_controls');
        $this->dropColumn('age_related_change', 'min_age_of_experiment');
        $this->dropColumn('age_related_change', 'max_age_of_experiment');

        $this->dropColumn('age_related_change', 'n_of_controls');
        $this->dropColumn('age_related_change', 'n_of_experiment');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220331_141021_blue_form_min_max_age cannot be reverted.\n";

        return false;
    }
    */
}
