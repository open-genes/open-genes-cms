<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211210_081931_replace_genotype_to_polymorphism
 */
class m211210_081931_replace_genotype_to_polymorphism extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('RENAME TABLE genotype TO polymorphism');
        $this->createTable('genotype', [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING,
        ]
        );

        $this->batchInsert(
            'genotype',
            ['id', 'name'],
            [
                [1, '+/-'],
                [2, '-/-'],
                [3, '+/++'],
                [4, '++/++']
            ]
        );

        $this->execute('ALTER TABLE lifespan_experiment MODIFY genotype INTEGER');
        $this->addForeignKey('lifespan_experiment_genotype', 'lifespan_experiment', 'genotype', 'genotype', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('lifespan_experiment_genotype', 'lifespan_experiment');
        $this->execute('ALTER TABLE lifespan_experiment MODIFY genotype TINYINT');
        $this->dropTable('genotype');
        $this->execute('RENAME TABLE polymorphism TO genotype');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211210_081931_replace_genotype_to_polymorphism cannot be reverted.\n";

        return false;
    }
    */
}
