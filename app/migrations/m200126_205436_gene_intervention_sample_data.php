<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200126_205436_gene_intervention_sample_data
 */
class m200126_205436_gene_intervention_sample_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('vital_process', [
            'name_en' => 'skeletal muscle and liver sensitivity to insulin',
            'name_ru' => 'чувствительность скелетных мышц и печени к инсулину',
        ]);
        $this->insert('vital_process', [
            'name_en' => 'mitochondrial biogenesis',
            'name_ru' => 'биогенез митохондрий',
        ]);
        $this->insert('intervention_result_for_vital_process', [
            'name_en' => 'improves',
            'name_ru' => 'улучшает',
        ]);
        $this->insert('intervention_result_for_vital_process', [
            'name_en' => 'normalizes',
            'name_ru' => 'нормализует',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200126_184601_gene_intervention_improves_longevity cannot be reverted.\n";

        return false;
    }
    */
}
