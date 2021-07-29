<?php

use yii\db\Migration;

/**
 * Class m210728_162318_add_og_summary_fields
 */
class m210728_162318_add_og_summary_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene', 'og_summary_en', $this->text());
        $this->addColumn('gene', 'og_summary_ru', $this->text());

        $this->renameColumn('gene', 'summary_en', 'ncbi_summary_en');
        $this->renameColumn('gene', 'summary_ru', 'ncbi_summary_ru');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene', 'og_summary_en');
        $this->dropColumn('gene', 'og_summary_ru');

        $this->renameColumn('gene', 'ncbi_summary_en', 'summary_en');
        $this->renameColumn('gene', 'ncbi_summary_ru', 'summary_ru');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210728_162318_add_og_summary_fields cannot be reverted.\n";

        return false;
    }
    */
}
