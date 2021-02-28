<?php

use yii\db\Migration;

/**
 * Class m200115_211516_lifespan_experiments_sample_data
 */
class m200115_211516_lifespan_experiments_sample_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('gene_intervention', [
            'name_en' => 'gene knockout',
            'name_ru' => 'нокаут гена',
        ]);
        $this->insert('gene_intervention', [
            'name_en' => 'decreased gene expression using RNA interference',
            'name_ru' => 'снижение экспрессии гена с помощью РНК-интерференции',
        ]);
        $this->insert('intervention_result', [
            'name_en' => 'reduces mortality',
            'name_ru' => 'снижает смертность',
        ]);
        $this->insert('model_organism', [
            'name_en' => 'mice',
            'name_ru' => 'мыши',
        ]);

        $this->insert('model_organism', [
            'name_en' => 'hamsters',
            'name_ru' => 'хомяки',
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
        echo "m191118_180752_gene_function_sample_data cannot be reverted.\n";

        return false;
    }
    */
}
