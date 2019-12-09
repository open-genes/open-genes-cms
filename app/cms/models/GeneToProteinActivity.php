<?php

namespace cms\models;

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
     * @param GeneToProteinActivity[] $geneToProteinActivities
     * @param int $geneId
     */
    public static function saveMultipleForGene(array $geneToProteinActivities, int $geneId)
    {
        foreach ($geneToProteinActivities as $id => $geneToProteinActivity) {
            if($geneToProteinActivity['protein_activity_id'] && $geneToProteinActivity['protein_activity_object_id']) {
                if(is_numeric($id)) {
                    $arGeneToProteinActivity = self::findOne($id);
                } else {
                    $arGeneToProteinActivity = new self();
                }
                if ($geneToProteinActivity['delete'] === '1') {
                    $arGeneToProteinActivity->delete();
                    continue;
                }
                $arGeneToProteinActivity->setAttributes($geneToProteinActivity);
                $arGeneToProteinActivity->gene_id = $geneId;
                if($arGeneToProteinActivity->process_localization_id === '') {
                    $arGeneToProteinActivity->process_localization_id = null;
                }
                if(!$arGeneToProteinActivity->save()) {
                    var_dump($arGeneToProteinActivity->errors); die;
                }
            }
        }
    }

}
