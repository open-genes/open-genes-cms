<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sample".
 *
 */
class Sample extends common\Sample
{
    use RuEnActiveRecordTrait;

    public $name;

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

    public function getLinkedGenesIds()
    {
        return $this->getGeneExpressionInSamples()
            ->select('gene_id')->distinct()->column();
    }

}
