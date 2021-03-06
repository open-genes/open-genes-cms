<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class GeneToLongevityEffect extends common\GeneToLongevityEffect
{
    public $delete = false;

    public function behaviors()
    {
        return [
            ChangelogBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['gene_id', 'longevity_effect_id', 'genotype_id'], 'required'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить'
        ]);
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
            if($modelArray['genotype_id'] && $modelArray['longevity_effect_id']) {
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
                if(!empty($modelArray['genotype_id']) && !is_numeric($modelArray['genotype_id'])) {
                    $arGenotype = Genotype::createFromNameString($modelArray['genotype_id']);
                    $modelAR->genotype_id = $arGenotype->id;
                }
                if(!empty($modelArray['model_organism_id']) && !is_numeric($modelArray['model_organism_id'])) {
                    $arProcessLocalization = ModelOrganism::createFromNameString($modelArray['model_organism_id']);
                    $modelAR->model_organism_id = $arProcessLocalization->id;
                }
                if($modelAR->genotype_id === '') {
                    $modelAR->genotype_id = null;
                }
                if($modelAR->model_organism_id === '') {
                    $modelAR->model_organism_id = null;
                }
                $modelAR->gene_id = $geneId;
                if(!$modelAR->save()) {
                    var_dump($modelAR->errors); die;
                }
            }
        }
    }

}
