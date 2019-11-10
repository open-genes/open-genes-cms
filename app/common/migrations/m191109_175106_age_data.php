<?php

use yii\db\Migration;

/**
 * Class m191109_175106_age_data
 */
class m191109_175106_age_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('age', [
            'name_phylo' => 'Chordata',
            'name_mya' => '900',
            'order' => '5',
        ]);
        $this->insert('age', [
            'name_phylo' => 'Eukaryota',
            'name_mya' => '2000',
            'order' => '7',
        ]);
        $this->insert('age', [
            'name_phylo' => 'Eumetazoa',
            'name_mya' => '1000',
            'order' => '6',
        ]);
        $this->insert('age', [
            'name_phylo' => 'Euteleostomi',
            'name_mya' => '500',
            'order' => '4',
        ]);
        $this->insert('age', [
            'name_phylo' => 'Mammalia',
            'name_mya' => '200',
            'order' => '1',
        ]);
        $this->insert('age', [
            'name_phylo' => 'Opisthokonta',
            'name_mya' => '2000',
            'order' => '8',
        ]);
        $this->insert('age', [
            'name_phylo' => 'Osteichthyes',
            'name_mya' => '420',
            'order' => '2',
        ]);
        $this->insert('age', [
            'name_phylo' => 'Prokaryota',
            'name_mya' => '3000',
            'order' => '9',
        ]);
        $this->insert('age', [
            'name_phylo' => 'Vertebrata',
            'name_mya' => '500',
            'order' => '3',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191109_175106_age_data cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191109_175106_age_data cannot be reverted.\n";

        return false;
    }
    */
}
