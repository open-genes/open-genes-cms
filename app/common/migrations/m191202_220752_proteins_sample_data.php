<?php

use yii\db\Migration;

/**
 * Class m191202_220752_proteins_sample_data
 */
class m191202_220752_proteins_sample_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('protein_activity_object', [
            'name_en' => 'cAMP synthesis',
            'name_ru' => 'синтез цАМФ',
        ]);
        $this->insert('protein_activity_object', [
            'name_en' => 'lipolysis',
            'name_ru' => 'липолиз',
        ]);
        $this->insert('protein_activity_object', [
            'name_en' => 'gluconeogenesis',
            'name_ru' => 'глюконеогенез',
        ]);
        $this->insert('protein_activity_object', [
            'name_en' => 'pro-inflammatory cytokines production',
            'name_ru' => 'выработка провоспалительных цитокинов',
        ]);

        $this->insert('protein_activity', [
            'name_en' => 'catalyses',
            'name_ru' => 'катализирует',
        ]);
        $this->insert('protein_activity', [
            'name_en' => 'controls',
            'name_ru' => 'отвечает за',
        ]);
        $this->insert('protein_activity', [
            'name_en' => 'inhibits',
            'name_ru' => 'ингибирует',
        ]);
        $this->insert('protein_activity', [
            'name_en' => 'involved in',
            'name_ru' => 'участвует',
        ]);

        $this->insert('process_localization', [
            'name_en' => 'brain',
            'name_ru' => 'мозг',
        ]);
        $this->insert('process_localization', [
            'name_en' => 'heart',
            'name_ru' => 'сердце',
        ]);

        $this->insert('protein_class', [
            'name_en' => 'Enzymes',
            'name_ru' => 'Энзимы',
        ]);
        $this->insert('protein_class', [
            'name_en' => 'Transporters',
            'name_ru' => 'Транспортеры',
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
