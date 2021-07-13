<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "functional_cluster".
 *
 */
class FunctionalCluster extends common\FunctionalCluster
{

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_en' => 'Name En',
            'name_ru' => 'Name Ru',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findAllAsArray()
    {
        $result = [];
        $commentCauses = self::find()->all();
        foreach ($commentCauses as $commentCause) {
            $result[$commentCause->id] = $commentCause->name_ru;
        }

        return $result;
    }

    public function getLinkedGenesIds()
    {
        return $this->getGeneToFunctionalClusters()
            ->select('gene_id')->distinct()->column();
    }
}
