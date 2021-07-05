<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\ExperimentTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class GeneToProteinActivity extends common\GeneToProteinActivity
{
    use ExperimentTrait;

    public $delete = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['gene_id', 'protein_activity_id', 'protein_activity_object_id'], 'required'],
        ]);
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
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

    private static function setExperimentValuesForGene($modelAR, $modelArray)
    {
        if(!empty($modelArray['protein_activity_object_id']) && !is_numeric($modelArray['protein_activity_object_id'])) {
            $arProteinActivityObject = ProteinActivityObject::createFromNameString($modelArray['protein_activity_object_id']);
            $modelAR->protein_activity_object_id = $arProteinActivityObject->id;
        }
        if(!empty($modelArray['process_localization_id']) && !is_numeric($modelArray['process_localization_id'])) {
            $arProcessLocalization = ProcessLocalization::createFromNameString($modelArray['process_localization_id']);
            $modelAR->process_localization_id = $arProcessLocalization->id;
        }
        if(!empty($modelArray['protein_activity_id']) && !is_numeric($modelArray['protein_activity_id'])) {
            $arProteinActivity = ProteinActivity::createFromNameString($modelArray['protein_activity_id']);
            $modelAR->protein_activity_id = $arProteinActivity->id;
        }
        if($modelAR->process_localization_id === '') {
            $modelAR->process_localization_id = null;
        }
    }

}
