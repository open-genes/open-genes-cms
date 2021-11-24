<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211116_162451_delete_sex_from_lifespan_experiment
 */
class m211116_162451_delete_sex_from_lifespan_experiment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('lifespan_experiment', 'lifespan_change_percent_male');
        $this->dropColumn('lifespan_experiment', 'lifespan_change_percent_female');
        $this->dropColumn('lifespan_experiment', 'lifespan_change_percent_common');
        $this->dropColumn('lifespan_experiment', 'sex');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('lifespan_experiment', 'lifespan_change_percent_male', Schema::TYPE_FLOAT);
        $this->addColumn('lifespan_experiment', 'lifespan_change_percent_female', Schema::TYPE_FLOAT);
        $this->addColumn('lifespan_experiment', 'lifespan_change_percent_common', Schema::TYPE_FLOAT);
        $this->addColumn('lifespan_experiment', 'sex', Schema::TYPE_TINYINT);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211116_162451_delete_sex_from_lifespan_experiment cannot be reverted.\n";

        return false;
    }
    */
}
