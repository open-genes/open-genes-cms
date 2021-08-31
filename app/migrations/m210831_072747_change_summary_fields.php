<?php

use yii\db\Migration;

/**
 * Class m210831_072747_change_summary_fields
 */
class m210831_072747_change_summary_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('update gene set og_summary_ru=commentFunction, og_summary_en=commentFunctionEN');
        $this->addColumn('gene', 'uniprot_summary_en', $this->text()->comment('Описание функции белка UniProt EN'));
        $this->addColumn('gene', 'uniprot_summary_ru', $this->text()->comment('Описание функции белка UniProt RU'));
        // todo delete commentFunction fields after changes in api project
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene', 'uniprot_summary_en');
        $this->dropColumn('gene', 'uniprot_summary_ru');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210831_072747_change_summary_fields cannot be reverted.\n";

        return false;
    }
    */
}
