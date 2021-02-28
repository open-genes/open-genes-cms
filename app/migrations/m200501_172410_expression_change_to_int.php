<?php

use yii\db\Migration;

/**
 * Class m200501_172410_expression_change_to_int
 */
class m200501_172410_expression_change_to_int extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('gene', ['expressionChange' => 0], ['expressionChange' => null]);
        $this->update('gene', ['expressionChange' => 0], ['expressionChange' => '']);
        $this->update('gene', ['expressionChange' => 1], ['expressionChange' => 'уменьшается']);
        $this->update('gene', ['expressionChange' => 2], ['expressionChange' => 'увеличивается']);
        $this->update('gene', ['expressionChange' => 3], ['expressionChange' => 'неоднозначно']);
        
        $this->alterColumn('gene', 'expressionChange', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('gene', 'expressionChange', $this->string());

        $this->update('gene', ['expressionChange' => null], ['expressionChange' => 0]);
        $this->update('gene', ['expressionChange' => 'уменьшается'], ['expressionChange' => 1]);
        $this->update('gene', ['expressionChange' => 'увеличивается'], ['expressionChange' => 2]);
        $this->update('gene', ['expressionChange' => 'неоднозначно'], ['expressionChange' => 3]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200501_172410_expression_change_to_int cannot be reverted.\n";

        return false;
    }
    */
}
