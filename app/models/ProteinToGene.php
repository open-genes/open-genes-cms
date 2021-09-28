<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\exceptions\UpdateExperimentsException;
use app\models\traits\ExperimentsActiveRecordTrait;
use app\models\traits\ValidatorsTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class ProteinToGene extends common\ProteinToGene
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
            [['gene_id', 'protein_activity_id', 'regulated_gene_id', 'regulation_type_id'], 'required'],
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
            if ($modelArray['delete'] === '1' && $modelAR instanceof ActiveRecord)  {
                $modelAR->delete();
                continue;
            }
            $modelAR->setAttributes($modelArray);
            if (!empty($modelArray['protein_activity_id']) && !is_numeric($modelArray['protein_activity_id'])) {
                $arProteinActivity = ProteinActivity::createFromNameString($modelArray['protein_activity_id']);
                $modelAR->protein_activity_id = $arProteinActivity->id;
            }
            if (!empty($modelArray['regulation_type_id']) && !is_numeric($modelArray['regulation_type_id'])) {
                $arProteinActivity = GeneRegulationType::createFromNameString($modelArray['regulation_type_id']);
                $modelAR->regulation_type_id = $arProteinActivity->id;
            }
            $modelAR->gene_id = $geneId;
            if (!$modelAR->validate() || !$modelAR->save()) {
                throw new UpdateExperimentsException($id, $modelAR);
            }
        }
    }

}
