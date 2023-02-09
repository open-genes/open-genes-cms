<?php

use yii\db\Migration;

/**
 * Class m230208_145705_change_cascade_to_setnull_on_lifespan_experiment
 */
class m230208_145705_change_cascade_to_setnull_on_lifespan_experiment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE lifespan_experiment DROP CONSTRAINT lifespan_experiment_genotype');

        $this->execute('ALTER TABLE lifespan_experiment ADD CONSTRAINT `lifespan_experiment_genotype_fk`
FOREIGN KEY(genotype) REFERENCES genotype (id) ON DELETE SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('ALTER TABLE lifespan_experiment DROP CONSTRAINT lifespan_experiment_genotype_fk');

        $this->execute('ALTER TABLE lifespan_experiment ADD CONSTRAINT `lifespan_experiment_genotype`
FOREIGN KEY(genotype) REFERENCES genotype (id) ON DELETE CASCADE');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230208_145705_change_cascade_to_setnull_on_lifespan_experiment cannot be reverted.\n";

        return false;
    }
    */
}
