<?php

use yii\db\Migration;

/**
 * Class m211228_133959_description_of_therapy
 */
class m211228_133959_description_of_therapy extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('lifespan_experiment_active_substance_dosage_unit', 'lifespan_experiment');
        $this->dropColumn('lifespan_experiment', 'active_substance_daily_dose');
        $this->dropColumn('lifespan_experiment', 'active_substance_daily_doses_number');
        $this->dropColumn('lifespan_experiment', 'daily_dose_sci_not_degree');
        $this->dropColumn('lifespan_experiment', 'active_substance_dosage_unit_id');

        $this->addColumn('lifespan_experiment', 'description_of_therapy_ru', $this->text()
            ->comment('Описание курса терапии ru'));
        $this->addColumn('lifespan_experiment', 'description_of_therapy_en', $this->text()
            ->comment('Описание курса терапии en'));

        $this->dropTable('active_substance_dosage_unit');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('lifespan_experiment', 'active_substance_daily_dose', $this->smallInteger()
            ->comment('Дневная доза'));
        $this->addColumn('lifespan_experiment', 'active_substance_daily_doses_number', $this->smallInteger()
            ->comment('Количество воздействий в день'));
        $this->addColumn('lifespan_experiment', 'daily_dose_sci_not_degree', $this->float()
            ->comment('Дневная доза - порядок в научной нотации')->defaultValue(0));
        $this->addColumn('lifespan_experiment', 'active_substance_dosage_unit_id', $this->integer());
        $this->addForeignKey('lifespan_experiment_active_substance_dosage_unit', 'lifespan_experiment', 'active_substance_dosage_unit_id', 'active_substance_dosage_unit', 'id');
        $this->dropColumn('lifespan_experiment', 'description_of_therapy_ru');
        $this->dropColumn('lifespan_experiment', 'description_of_therapy_en');

        $this->createTable('active_substance_dosage_unit', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('active_substance_dosage_unit', 'Размерность дозировки вещества');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211228_133959_description_of_therapy cannot be reverted.\n";

        return false;
    }
    */
}
