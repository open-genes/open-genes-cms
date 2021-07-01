<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\exceptions\UpdateExperimentsException;
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
            if (!empty($modelArray['progeria_syndrome_id']) && !is_numeric($modelArray['progeria_syndrome_id'])) {
                $arProgeriaSyndrome = ProgeriaSyndrome::createFromNameString($modelArray['progeria_syndrome_id']);
                $modelAR->progeria_syndrome_id = $arProgeriaSyndrome->id;
            }
            $modelAR->gene_id = $geneId;
            if (!$modelAR->validate() || !$modelAR->save()) {
                throw new UpdateExperimentsException($id, $modelAR);
            }
        }
    }

}
