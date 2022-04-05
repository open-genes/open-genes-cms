<?php

use yii\db\Migration;

/**
 * Class m220404_095207_blue_form_sex
 */
class m220404_095207_blue_form_sex extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('age_related_change', 'sex', $this->integer());

        $this->execute("update age_related_change
                                set sex = 0
                                where change_value_female is not null");

        $this->execute("update age_related_change
                                set sex = 1
                                where change_value_male is not null");

        $this->execute("update age_related_change
                                set sex = 3
                                where change_value_common is not null");

        $this->execute("update age_related_change
                                set sex = 4
                                where model_organism_id = 
                                      (select id from model_organism where name_lat = 'Caenorhabditis elegans')");

        $this->addColumn('age_related_change', 'change_value', $this->float());

        $this->execute("update age_related_change
                                set change_value = change_value_female
                                where sex = 0");

        $this->execute("update age_related_change
                                set change_value = change_value_male
                                where sex = 1");

        $this->execute("update age_related_change
                                set change_value = change_value_common
                                where sex in (3, 4)");

        $this->dropColumn('age_related_change', 'change_value_common');
        $this->dropColumn('age_related_change', 'change_value_male');
        $this->dropColumn('age_related_change', 'change_value_female');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('age_related_change', 'change_value_common', $this->float());
        $this->addColumn('age_related_change', 'change_value_male', $this->float());
        $this->addColumn('age_related_change', 'change_value_female', $this->float());

        $this->dropColumn('age_related_change', 'sex');
        $this->dropColumn('age_related_change', 'change_value');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220404_095207_blue_form_sex cannot be reverted.\n";

        return false;
    }
    */
}
