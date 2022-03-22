<?php

use yii\db\Migration;

/**
 * Class m220322_105510_cr_result_ru
 */
class m220322_105510_cr_result_ru extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('calorie_restriction_experiment', 'result', 'result_en');
        $this->addColumn('calorie_restriction_experiment', 'result_ru', \yii\db\Schema::TYPE_STRING);

        $this->execute("UPDATE calorie_restriction_experiment SET result_ru='убывает' WHERE result_en='decrease'");
        $this->execute("UPDATE calorie_restriction_experiment SET result_ru='возрастает' WHERE result_en='increase'");
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('calorie_restriction_experiment', 'result_ru');
        $this->renameColumn('calorie_restriction_experiment', 'result_en', 'result');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220322_105510_cr_result_ru cannot be reverted.\n";

        return false;
    }
    */
}
