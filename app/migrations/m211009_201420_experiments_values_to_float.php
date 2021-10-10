<?php

use yii\db\Migration;

/**
 * Class m211009_201420_experiments_values_to_float
 */
class m211009_201420_experiments_values_to_float extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('general_lifespan_experiment', 'control_lifespan_min', $this->float()->comment('Мин. прод-ть жизни контроля'));
        $this->alterColumn('general_lifespan_experiment', 'control_lifespan_mean', $this->float()->comment('Сред. прод-ть жизни контроля'));
        $this->alterColumn('general_lifespan_experiment', 'control_lifespan_median', $this->float()->comment('Мед. прод-ть жизни контроля'));
        $this->alterColumn('general_lifespan_experiment', 'control_lifespan_max', $this->float()->comment('Макс. прод-ть жизни контроля'));
        
        $this->alterColumn('general_lifespan_experiment', 'experiment_lifespan_min', $this->float()->comment('Мин. прод-ть жизни эксперимента'));
        $this->alterColumn('general_lifespan_experiment', 'experiment_lifespan_mean', $this->float()->comment('Сред. прод-ть жизни эксперимента'));
        $this->alterColumn('general_lifespan_experiment', 'experiment_lifespan_median', $this->float()->comment('Мед. прод-ть жизни эксперимента'));
        $this->alterColumn('general_lifespan_experiment', 'experiment_lifespan_max', $this->float()->comment('Макс. прод-ть жизни эксперимента'));
        
        $this->alterColumn('general_lifespan_experiment', 'lifespan_min_change', $this->float()->comment('Мин. прод-ть жизни % изменения'));
        $this->alterColumn('general_lifespan_experiment', 'lifespan_mean_change', $this->float()->comment('Сред. прод-ть жизни % изменения'));
        $this->alterColumn('general_lifespan_experiment', 'lifespan_median_change', $this->float()->comment('Мед. прод-ть жизни % изменения'));
        $this->alterColumn('general_lifespan_experiment', 'lifespan_max_change', $this->float()->comment('Макс. прод-ть жизни % изменения'));
        
        $this->alterColumn('general_lifespan_experiment', 'expression_change', $this->float()->comment('Степень изменения экспрессии гена %'));
        
        $this->alterColumn('lifespan_experiment', 'active_substance_daily_dose', $this->float()->comment('Дневная доза'));
        $this->addColumn('lifespan_experiment', 'daily_dose_sci_not_degree', $this->float()
            ->comment('Дневная доза - порядок в научной нотации')->defaultValue(0));
        
        $this->alterColumn('lifespan_experiment', 'treatment_start', $this->float()->comment('Начало периода воздействия'));
        $this->alterColumn('lifespan_experiment', 'treatment_end', $this->float()->comment('Конец периода воздействия'));
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('lifespan_experiment', 'daily_dose_sci_not_degree');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211009_201420_experiments_values_to_float cannot be reverted.\n";

        return false;
    }
    */
}
