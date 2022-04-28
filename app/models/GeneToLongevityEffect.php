<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\exceptions\UpdateExperimentsException;
use app\models\traits\ExperimentsActiveRecordTrait;
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
            [['gene_id', 'longevity_effect_id', 'data_type'], 'required'],
            [['reference'], 'validateDOI']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить',
            'longevity_effect_id' => 'Эффект',
            'polymorphism_id' => 'Аллельный полиморфизм',
            'sex_of_organism' => 'Пол',
            'allele_variant' => 'Аллельный вариант',
            'reference' => 'Ссылка',
            'data_type' => 'Тип изменений',
            'age_related_change_type_id' => 'Вид изменений',
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
            self::setAttributeFromNewAR($modelArray, 'longevity_effect_id', 'LongevityEffect', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'polymorphism_id', 'Genotype', $modelAR);
            self::setAttributeFromNewAR($modelArray, 'age_related_change_type_id', 'AgeRelatedChangeType', $modelAR);

            $modelAR->gene_id = $geneId;
            if (!$modelAR->validate() || !$modelAR->save()) {
                throw new UpdateExperimentsException($id, $modelAR);
            }
        }
    }

}
