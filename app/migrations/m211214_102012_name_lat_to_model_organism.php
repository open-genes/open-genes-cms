<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211214_102012_name_lat_to_model_organism
 */
class m211214_102012_name_lat_to_model_organism extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('model_organism', 'name_lat', Schema::TYPE_STRING . ' AFTER name_en');
        $this->update('model_organism', ['name_ru' => 'термит Reticulitermes speratus'], ['name_en' => 'термит Reticulitermes speratus']);
        $this->update('model_organism', ['name_en' => 'termite Reticulitermes speratus'], ['name_en' => 'термит Reticulitermes speratus']);
        $this->delete('model_organism', ['name_en' => 'ducks']);
        $this->insert('model_organism', ['name_ru' => null, 'name_en' => 'Cairina moschata', 'name_lat' => 'Cairina moschata']);
        $names = [
            'mice' => 'Mus musculus',
            'hamsters' => 'Mesocricetus auratus',
            'rats' => 'Rattus norvegicus',
            'human' => 'Homo sapiens',
            'nematode C. elegans' => 'Caenorhabditis elegans',
            'rhesus monkeys' => 'Macaca mulatta',
            'cell culture' => 'Cellula',
            'Drosophila melanogaster' => 'Drosophila melanogaster',
            'cow' => 'Bos taurus',
            'pigs' => 'Sus scrofa',
            'fish Nothobranchius furzeri' => 'Nothobranchius furzeri',
            'Danio rerio' => 'Danio rerio',
            'cat' => 'Felis catus',
            'fungus Podospora anserina' => 'Podospora anserina',
            'dog' => 'Canis lupus familiaris',
            'rabbits' => 'Oryctolagus cuniculus',
            'human tissue culture' => 'Homo sapiens',
            'axolotl' => 'Ambystoma mexicanum',
            'gerbil' => 'Meriones unguiculatus',
            'Macaca fascicularis' => 'Macaca fascicularis',
            'yeasts' => 'Saccharomyces cerevisiae',
            'buffalo' => 'Bubalus bubalis',
            'mole-rat' => 'Heterocephalus glaber',
            'goat' => 'Capra hircus',
            'horse' => 'Equus caballus',
            'acyrthosiphon pisum' => 'Acyrthosiphon pisum',
            'flatworm Macrostomum lignano' => 'Macrostomum lignano',
            'primates' => 'Primates',
            'birds' => 'Aves',
            'fish Nothobranchius guentheri' => 'Nothobranchius guentheri',
            'Aplysia' => 'Aplysia californica',
            'termite Reticulitermes speratus' => 'Reticulitermes speratus',
        ];

        foreach ($names as $name_en => $name_lat) {
            $this->update('model_organism', ['name_lat' => $name_lat], ['name_en' => $name_en]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('model_organism', 'name_lat');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211214_102012_name_lat_to_model_organism cannot be reverted.\n";

        return false;
    }
    */
}
