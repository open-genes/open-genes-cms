<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\exceptions\UpdateExperimentsException;
use app\models\traits\ExperimentsActiveRecordTrait;
use app\models\traits\ValidatorsTrait;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age_related_change".
 *
 */
class AgeRelatedChange extends common\AgeRelatedChange
{
    use ValidatorsTrait;
    use ExperimentsActiveRecordTrait;

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
            [['gene_id', 'age_related_change_type_id', 'model_organism_id'], 'required'],
            [['age_unit_id'], 'required', 'when' => function($model) {
                return !empty($model->mean_age_of_controls) || !empty($model->mean_age_of_experiment);
            }],
            [['mean_age_of_controls', 'mean_age_of_experiment', 'min_age_of_controls', 'max_age_of_controls', 'min_age_of_experiment', 'max_age_of_experiment'], 'number', 'min'=>0],
            [['reference'], 'validateDOI']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить',
            'age_related_change_type_id' => 'Вид изменений',
            'sample_id' => 'Образец',
            'reference' => 'Ссылка',
            'model_organism_id' => 'Объект',
            'organism_line_id' => 'Линия',
            'mean_age_of_controls' => 'Средний возраст контроля',
            'mean_age_of_experiment' => 'Средний возраст эксперимента',
            'min_age_of_controls' => 'мин. возраст контроля',
            'max_age_of_controls' => 'макс. возраст контроля',
            'min_age_of_experiment' => 'мин. возраст эксперимента',
            'max_age_of_experiment' => 'макс. возраст эксперимента',
            'age_unit_id' => 'Ед. измерения возраста',
            'change_value' => 'Изменение',
        ]);
    }

    public function beforeValidate()
    {
        $this->change_value = str_replace(',', '.', $this->change_value);
        $this->mean_age_of_controls = str_replace(',', '.', $this->mean_age_of_controls);
        $this->mean_age_of_experiment = str_replace(',', '.', $this->mean_age_of_experiment);
        $this->min_age_of_controls = str_replace(',', '.', $this->min_age_of_controls);
        $this->max_age_of_controls = str_replace(',', '.', $this->max_age_of_controls);
        $this->min_age_of_experiment = str_replace(',', '.', $this->min_age_of_experiment);
        $this->max_age_of_experiment = str_replace(',', '.', $this->max_age_of_experiment);

        return parent::beforeValidate();
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
            if (is_numeric($id)) {
                $modelAR = self::findOne($id);
            } else {
                $modelAR = new self();
            }
            if ($modelArray['delete'] === '1' && $modelAR instanceof ActiveRecord) {
                $modelAR->delete();
                continue;
            }
            $modelAR->setAttributes($modelArray);
            if (!empty($modelArray['age_related_change_type_id']) && !is_numeric($modelArray['age_related_change_type_id'])) {
                $arProteinActivityObject = AgeRelatedChangeType::createFromNameString($modelArray['age_related_change_type_id']);
                $modelAR->age_related_change_type_id = $arProteinActivityObject->id;
            }
            if (!empty($modelArray['sample_id']) && !is_numeric($modelArray['sample_id'])) {
                $arProcessLocalization = Sample::createFromNameString($modelArray['sample_id']);
                $modelAR->sample_id = $arProcessLocalization->id;
            }
            if (!empty($modelArray['model_organism_id']) && !is_numeric($modelArray['model_organism_id'])) {
                $arProcessLocalization = ModelOrganism::createFromNameString($modelArray['model_organism_id']);
                $modelAR->model_organism_id = $arProcessLocalization->id;
            }
            if (!empty($modelArray['organism_line_id']) && !is_numeric($modelArray['organism_line_id'])) {
                $arProteinActivity = OrganismLine::createFromNameString($modelArray['organism_line_id'], ['model_organism_id' => $modelAR->model_organism_id]);
                $modelAR->organism_line_id = $arProteinActivity->id;
            }
            else {
                OrganismLine::fixLine($modelAR, $modelArray);
            }

            if ($modelAR->organism_line_id === '') {
                $modelAR->organism_line_id = null;
            }
            $modelAR->gene_id = $geneId;
            if (!$modelAR->validate() || !$modelAR->save()) {
                throw new UpdateExperimentsException($id, $modelAR);
            }
        }
    }

}
