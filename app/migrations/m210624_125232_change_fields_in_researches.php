<?php

use yii\db\Migration;

/**
 * Class m210624_125232_change_fields_in_researches
 */
class m210624_125232_change_fields_in_researches extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene_to_longevity_effect', 'data_type', $this->tinyInteger());
        $this->addColumn('gene_to_longevity_effect', 'age_related_change_type_id', $this->integer());

        $this->addForeignKey('gene_to_longevity_effect_age_rel_type', 'gene_to_longevity_effect', 'age_related_change_type_id', 'age_related_change_type', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_longevity_effect_age_rel_type', 'gene_to_longevity_effect');

        $this->dropColumn('gene_to_longevity_effect', 'data_type');
        $this->dropColumn('gene_to_longevity_effect', 'age_related_change_type_id');


    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210624_125232_change_fields_in_researches cannot be reverted.\n";

        return false;
    }
    */
}
