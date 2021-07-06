<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\exceptions\UpdateExperimentsValidationException;
use app\models\traits\ExperimentTrait;
use app\models\traits\ValidatorsTrait;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class GeneToLongevityEffect extends common\GeneToLongevityEffect
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

    public function init() {
        parent::init();
        if ($this->isNewRecord) {
            $modelOrganismHumanId = ModelOrganism::find()->select('id')->where(['name_en' => 'human'])->scalar();
            $this->model_organism_id = $modelOrganismHumanId;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['gene_id', 'longevity_effect_id', 'genotype_id', 'reference', 'data_type', 'model_organism_id'], 'required'],
            [['reference'], 'validateDOI']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить',
            'longevity_effect_id' => 'Эффект',
            'genotype_id' => 'Аллельный полиморфизм',
            'sex_of_organism' => 'Пол',
            'allele_variant' => 'Аллельный вариант',
            'reference' => 'Ссылка',
            'data_type' => 'Тип изменений',
            'model_organism_id' => 'Объект',
            'age_related_change_type_id' => 'Вид изменений',
        ]);
    }

    private static function setExperimentValuesForGene(&$modelAR, $modelArray)
    {
        if (!empty($modelArray['longevity_effect_id']) && !is_numeric($modelArray['longevity_effect_id'])) {
            $arLongevityEffect = LongevityEffect::createFromNameString($modelArray['longevity_effect_id']);
            $modelAR->longevity_effect_id = $arLongevityEffect->id;
        }
        if (!empty($modelArray['genotype_id']) && !is_numeric($modelArray['genotype_id'])) {
            $arGenotype = Genotype::createFromNameString($modelArray['genotype_id']);
            $modelAR->genotype_id = $arGenotype->id;
        }
        if (!empty($modelArray['model_organism_id']) && !is_numeric($modelArray['model_organism_id'])) {
            $arProcessLocalization = ModelOrganism::createFromNameString($modelArray['model_organism_id']);
            $modelAR->model_organism_id = $arProcessLocalization->id;
        }
        if (!empty($modelArray['age_related_change_type_id']) && !is_numeric($modelArray['age_related_change_type_id'])) {
            $arProcessLocalization = AgeRelatedChangeType::createFromNameString($modelArray['age_related_change_type_id']);
            $modelAR->age_related_change_type_id = $arProcessLocalization->id;
        }
        if ($modelAR->genotype_id === '') {
            $modelAR->genotype_id = null;
        }
    }

}
