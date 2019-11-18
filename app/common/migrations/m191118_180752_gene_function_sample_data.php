<?php

use yii\db\Migration;

/**
 * Class m191118_180752_gene_function_sample_data
 */
class m191118_180752_gene_function_sample_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('function', [
            'name_en' => 'cAMP synthesis',
            'name_ru' => 'синтез цАМФ',
        ]);
        $this->insert('function', [
            'name_en' => 'lipolysis',
            'name_ru' => 'липолиз',
        ]);
        $this->insert('function', [
            'name_en' => 'gluconeogenesis',
            'name_ru' => 'глюконеогенез',
        ]);
        $this->insert('function', [
            'name_en' => 'pro-inflammatory cytokines production',
            'name_ru' => 'выработка провоспалительных цитокинов',
        ]);

        $this->insert('gene_to_function_relation_type', [
            'name_en' => 'catalyses',
            'name_ru' => 'катализирует',
        ]);
        $this->insert('gene_to_function_relation_type', [
            'name_en' => 'controls',
            'name_ru' => 'отвечает за',
        ]);
        $this->insert('gene_to_function_relation_type', [
            'name_en' => 'inhibits',
            'name_ru' => 'ингибирует',
        ]);
        $this->insert('gene_to_function_relation_type', [
            'name_en' => 'involved in',
            'name_ru' => 'участвует',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191118_180752_gene_function_sample_data cannot be reverted.\n";

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
