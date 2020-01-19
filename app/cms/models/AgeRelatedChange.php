<?php

namespace cms\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class AgeRelatedChange extends \common\models\AgeRelatedChange
{
    public $delete = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['gene_id', 'age_related_change_type_id', 'model_organism_id'], 'required'],
        ]);
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
            if($modelArray['age_related_change_type_id'] && $modelArray['model_organism_id']) {
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
                if(!is_numeric($modelArray['age_related_change_type_id'])) {
                    $arProteinActivityObject = AgeRelatedChangeType::createFromNameString($modelArray['age_related_change_type_id']);
                    $modelAR->age_related_change_type_id = $arProteinActivityObject->id;
                }
                if(!is_numeric($modelArray['sample_id'])) {
                    $arProcessLocalization = Sample::createFromNameString($modelArray['sample_id']);
                    $modelAR->sample_id = $arProcessLocalization->id;
                }
                if(!is_numeric($modelArray['model_organism_id'])) {
                    $arProcessLocalization = ModelOrganism::createFromNameString($modelArray['model_organism_id']);
                    $modelAR->model_organism_id = $arProcessLocalization->id;
                }
                if(!is_numeric($modelArray['organism_line_id'])) {
                    $arProteinActivity = OrganismLine::createFromNameString($modelArray['organism_line_id']);
                    $modelAR->organism_line_id = $arProteinActivity->id;
                }
                $modelAR->gene_id = $geneId;
                if(!$modelAR->save()) {
                    var_dump($modelAR->errors); die;
                }
            }
        }
    }

}
