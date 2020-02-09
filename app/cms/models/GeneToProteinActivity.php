<?php

namespace cms\models;

use cms\models\behaviors\ChangelogBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class GeneToProteinActivity extends \common\models\GeneToProteinActivity
{
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

    /**
     * @param array $modelArrays
     * @param int $geneId
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function saveMultipleForGene(array $modelArrays, int $geneId)
    {
        foreach ($modelArrays as $id => $modelArray) {
            if($modelArray['protein_activity_id'] && $modelArray['protein_activity_object_id']) {
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
                if(!is_numeric($modelArray['protein_activity_object_id'])) {
                    $arProteinActivityObject = ProteinActivityObject::createFromNameString($modelArray['protein_activity_object_id']);
                    $modelAR->protein_activity_object_id = $arProteinActivityObject->id;
                }
                if(!is_numeric($modelArray['process_localization_id'])) {
                    $arProcessLocalization = ProcessLocalization::createFromNameString($modelArray['process_localization_id']);
                    $modelAR->process_localization_id = $arProcessLocalization->id;
                }
                if(!is_numeric($modelArray['protein_activity_id'])) {
                    $arProteinActivity = ProteinActivity::createFromNameString($modelArray['protein_activity_id']);
                    $modelAR->protein_activity_id = $arProteinActivity->id;
                }
                $modelAR->gene_id = $geneId;
                if($modelAR->process_localization_id === '') {
                    $modelAR->process_localization_id = null;
                }
                if(!$modelAR->save()) {
                    var_dump($modelAR->errors); die;
                }
            }
        }
    }

}
