<?php

use yii\db\Migration;

/**
 * Class m210924_102411_add_column_model_organism_id_to_organism_line
 */
class m210924_102411_add_column_model_organism_id_to_organism_line extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('organism_line', 'model_organism_id', $this->integer()->after('name_en'));
        $this->addForeignKey(
            'model_organism_id_model_organism',
            'organism_line',
            'model_organism_id',
            'model_organism',
            'id'
        );
        $this->createIndex('id_model_organism_id', 'organism_line', ['id', 'model_organism_id'], true);

        $this->execute($this->updateModelOrganismIds('lifespan_experiment'));
        $this->execute($this->updateModelOrganismIds('age_related_change'));
        $this->execute($this->updateModelOrganismIds('gene_intervention_to_vital_process'));

        $this->insertDuplicateLines('lifespan_experiment');
        $this->insertDuplicateLines('age_related_change');
        $this->insertDuplicateLines('gene_intervention_to_vital_process');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('model_organism_id_model_organism', 'organism_line');
        $this->dropIndex('id_model_organism_id', 'organism_line');
        $this->dropColumn('organism_line', 'model_organism_id');
    }

    private function updateModelOrganismIds($source)
    {
        return 'UPDATE organism_line ol
                    JOIN ' . $source . ' tbl
                    ON ol.id = tbl.organism_line_id
                SET ol.model_organism_id = tbl.model_organism_id
                WHERE ol.model_organism_id IS NULL';
    }

    private function insertDuplicateLines($table)
    {
        $doubledLines = Yii::$app->db->createCommand(
            'SELECT DISTINCT model_organism_id, organism_line_id
                                FROM ' . $table . ' WHERE organism_line_id IN (
                                    SELECT organism_line_id FROM ' . $table . '
                                        GROUP BY organism_line_id
                                    HAVING COUNT(DISTINCT model_organism_id) > 1)'
        )->queryAll();

        $doubledLinesIds = implode(', ', array_column($doubledLines, 'organism_line_id'));
        if(!$doubledLinesIds){
            return;
        }
        $lines = Yii::$app->db->createCommand(
            'SELECT * FROM organism_line WHERE id IN (' . $doubledLinesIds . ')')->queryAll();
        $doubledLinesGroup = [];
        foreach ($doubledLines as $doubledLine) {
            if (!isset($doubledLinesGroup[$doubledLine['organism_line_id']])) {
                $doubledLinesGroup[$doubledLine['organism_line_id']] = [];
            }
            $doubledLinesGroup[$doubledLine['organism_line_id']][] = $doubledLine['model_organism_id'];
        }
        foreach ($lines as $line) {
            foreach ($doubledLinesGroup[$line['id']] as $organism) {
                if ($line['model_organism_id'] == $organism) {
                    continue;
                }
                $dataToInsert = $line;
                unset($dataToInsert['id']);
                $dataToInsert['model_organism_id'] = $organism;
                $this->insert('organism_line', $dataToInsert);
                $lastId = Yii::$app->db->getLastInsertId();
                foreach (
                    [
                        'lifespan_experiment',
                        'age_related_change',
                        'gene_intervention_to_vital_process'
                    ] as $table
                ) {
                    $this->update(
                        $table,
                        ['organism_line_id' => $lastId],
                        'model_organism_id = ' . $organism . ' and organism_line_id = ' . $line['id']
                    );
                }
            }
        }
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210924_102411_add_column_model_organism_id_to_organism_line cannot be reverted.\n";

        return false;
    }
    */
}
