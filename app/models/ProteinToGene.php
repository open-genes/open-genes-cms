<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\ExperimentTrait;
use app\models\traits\ValidatorsTrait;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class ProteinToGene extends common\ProteinToGene
{
    use ValidatorsTrait;
    use ExperimentTrait;

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
            [['gene_id', 'protein_activity_id', 'regulated_gene_id', 'regulation_type_id', 'reference'], 'required'],
            [['reference'], 'validateDOI']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить',
            'regulated_gene_id' => 'Ген',
            'protein_activity_id' => 'Активность',
            'reference' => 'Ссылка',
            'regulation_type_id' => 'Вид регуляции',
        ]);
    }

    private static function setExperimentValuesForGene(&$modelAR, $modelArray)
    {
        if (!empty($modelArray['protein_activity_id']) && !is_numeric($modelArray['protein_activity_id'])) {
            $arProteinActivity = ProteinActivity::createFromNameString($modelArray['protein_activity_id']);
            $modelAR->protein_activity_id = $arProteinActivity->id;
        }
        if (!empty($modelArray['regulation_type_id']) && !is_numeric($modelArray['regulation_type_id'])) {
            $arProteinActivity = GeneRegulationType::createFromNameString($modelArray['regulation_type_id']);
            $modelAR->regulation_type_id = $arProteinActivity->id;
        }
    }

}
