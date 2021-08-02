<?php

use yii\db\Migration;

/**
 * Class m210802_104020_comment_fields_to_text
 */
class m210802_104020_comment_fields_to_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('gene', 'commentEvolution', $this->text());
        $this->alterColumn('gene', 'commentFunction', $this->text());
        $this->alterColumn('gene', 'commentCause', $this->text());
        $this->alterColumn('gene', 'commentAging', $this->text());
        $this->alterColumn('gene', 'commentEvolutionEN', $this->text());
        $this->alterColumn('gene', 'commentFunctionEN', $this->text());
        $this->alterColumn('gene', 'commentAgingEN', $this->text());
        $this->alterColumn('gene', 'commentsReferenceLinks', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "ok.\n";
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210802_104020_comment_fields_to_text cannot be reverted.\n";

        return false;
    }
    */
}
