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
class GeneToAdditionalEvidence extends common\GeneToAdditionalEvidence
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
            [['gene_id', 'reference', 'comment_en'], 'required'],
            [['reference'], 'validateDOI']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
            'delete' => 'Удалить',
            'comment_ru' => 'Обоснование ассоциации',
            'comment_en' => 'Обоснование ассоциации EN',
            'reference' => 'Ссылка',
        ]);
    }

    private static function setExperimentValuesForGene($modelAR, $modelArray)
    {

    }

}
