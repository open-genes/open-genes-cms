<?php

namespace cms\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class GeneToLongevityEffect extends \common\models\GeneToLongevityEffect
{
    public $delete = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['gene_id', 'longevity_effect_id', 'gene_longevity_association_type_id'], 'required'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить'
        ]);
    }

    public static function findAllAsArray()
    {
        $result = [];
        $ages = self::find()->all();
        foreach ($ages as $age) {
            $result[$age->id] = $age->name_phylo;
        }

        return $result;
    }

    /**
     * @param array $modelArrays
     * @param int $geneId
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function saveMultipleForGene(array $modelArrays, int $geneId)
    {
        foreach ($modelArrays as $id => $modelArray) {
            if($modelArray['gene_longevity_association_type_id'] && $modelArray['longevity_effect_id']) {
                if(is_numeric($id)) {
                    $modelAR = self::findOne($id);
                } else {
                    $modelAR = new self();
                }
                if ($modelArray['delete'] === '1') {
                    $modelAR->delete();
                    continue;
                }
                $modelAR->setAttributes($modelArray);
                if(!is_numeric($modelArray['longevity_effect_id'])) {
                    $arLongevityEffect = LongevityEffect::createFromNameString($modelArray['longevity_effect_id']);
                    $modelAR->longevity_effect_id = $arLongevityEffect->id;
                }
                if(!is_numeric($modelArray['gene_longevity_association_type_id'])) {
                    $arGeneLongevityAssociationType = GeneLongevityAssociationType::createFromNameString($modelArray['gene_longevity_association_type_id']);
                    $modelAR->gene_longevity_association_type_id = $arGeneLongevityAssociationType->id;
                }
                if(!is_numeric($modelArray['model_organism_id'])) {
                    $arProcessLocalization = ModelOrganism::createFromNameString($modelArray['model_organism_id']);
                    $modelAR->model_organism_id = $arProcessLocalization->id;
                }
                if(!empty($modelArray['genotype_id']) && !is_numeric($modelArray['genotype_id'])) {
                    $arGenotype = Genotype::createFromNameString($modelArray['genotype_id']);
                    $modelAR->genotype_id = $arGenotype->id;
                }
                if(!empty($modelArray['organism_line_id']) && !is_numeric($modelArray['organism_line_id'])) {
                    $arProteinActivity = OrganismLine::createFromNameString($modelArray['organism_line_id']);
                    $modelAR->organism_line_id = $arProteinActivity->id;
                }
                if($modelAR->organism_line_id === '') {
                    $modelAR->organism_line_id = null;
                }
                if($modelAR->genotype_id === '') {
                    $modelAR->genotype_id = null;
                }
                $modelAR->gene_id = $geneId;
                if(!$modelAR->save()) {
                    var_dump($modelAR->errors); die;
                }
            }
        }
    }

}
