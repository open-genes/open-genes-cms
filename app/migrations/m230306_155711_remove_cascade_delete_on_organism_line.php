<?php

use yii\db\Migration;

/**
 * Class m230306_155711_remove_cascade_delete_on_organism_line
 */
class m230306_155711_remove_cascade_delete_on_organism_line extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE gene_intervention_to_vital_process DROP CONSTRAINT interv_to_vital_pr_organism_line');
        $this->execute('ALTER TABLE gene_intervention_to_vital_process ADD CONSTRAINT `interv_to_vital_pr_organism_line_fk`
FOREIGN KEY(organism_line_id) REFERENCES organism_line (id) ON DELETE RESTRICT');

        $this->execute('ALTER TABLE age_related_change DROP CONSTRAINT age_related_change_organism_line');
        $this->execute('ALTER TABLE age_related_change ADD CONSTRAINT `age_related_change_organism_line_fk`
FOREIGN KEY(organism_line_id) REFERENCES organism_line (id) ON DELETE RESTRICT');

        $this->execute('ALTER TABLE lifespan_experiment ADD CONSTRAINT `lifespan_experiment_organism_line_fk`
FOREIGN KEY(organism_line_id) REFERENCES organism_line (id) ON DELETE RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('ALTER TABLE gene_intervention_to_vital_process DROP CONSTRAINT interv_to_vital_pr_organism_line_fk');
        $this->execute('ALTER TABLE gene_intervention_to_vital_process ADD CONSTRAINT `interv_to_vital_pr_organism_line`
FOREIGN KEY(organism_line_id) REFERENCES organism_line (id) ON DELETE CASCADE');

        $this->execute('ALTER TABLE age_related_change DROP CONSTRAINT age_related_change_organism_line_fk');
        $this->execute('ALTER TABLE age_related_change ADD CONSTRAINT `age_related_change_organism_line`
FOREIGN KEY(organism_line_id) REFERENCES organism_line (id) ON DELETE CASCADE');

        $this->execute('ALTER TABLE lifespan_experiment DROP CONSTRAINT lifespan_experiment_organism_line_fk');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230306_155711_remove_cascade_delete_on_organism_line cannot be reverted.\n";

        return false;
    }
    */
}
