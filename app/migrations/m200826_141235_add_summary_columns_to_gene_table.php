<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles adding columns to table `{{%gene}}`.
 */
class m200826_141235_add_summary_columns_to_gene_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%gene}}', 'summary_ru', $this->text());
        $this->addColumn('{{%gene}}', 'summary_en', $this->text());
	$tsv_file=preg_replace('/.php$/','_summary.tsv',__FILE__);
	$f=fopen($tsv_file,'r');
	while (($line=fgets($f))!==false)
	{
		list($symbol,$summary_en)=explode("\t",trim($line));
		$re=$this->update('{{%gene}}',['summary_en'=>$summary_en],['symbol'=>$symbol]);
	};
	fclose($f);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%gene}}', 'summary_ru');
        $this->dropColumn('{{%gene}}', 'summary_en');
    }
}
