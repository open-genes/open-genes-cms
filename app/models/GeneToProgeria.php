<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\exceptions\UpdateExperimentsValidationException;
use app\models\traits\ExperimentTrait;
use app\models\traits\ValidatorsTrait;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class GeneToProgeria extends common\GeneToProgeria
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
            [['gene_id', 'progeria_syndrome_id', 'reference'], 'required'],
            [['reference'], 'validateDOI']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить',
            'progeria_syndrome_id' => 'Прогерический синдром',
            'reference' => 'Ссылка',
        ]);
    }

    private static function setExperimentValuesForGene(&$modelAR, $modelArray)
    {
        if (!empty($modelArray['progeria_syndrome_id']) && !is_numeric($modelArray['progeria_syndrome_id'])) {
            $arProgeriaSyndrome = ProgeriaSyndrome::createFromNameString($modelArray['progeria_syndrome_id']);
            $modelAR->progeria_syndrome_id = $arProgeriaSyndrome->id;
        }
    }

}
