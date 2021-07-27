<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\ConditionActiveRecordTrait;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class Genotype extends common\Genotype
{
    use RuEnActiveRecordTrait;
    use ConditionActiveRecordTrait;

    public $name;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }

    public function beforeSave($insert)
    {
        if (!$this->name_en) {
            $this->name_en = $this->name_ru;
        }
        if (!$this->name_ru) {
            $this->name_ru = $this->name_en;
        }
        return parent::beforeSave($insert);
    }

    public static function getAllNamesAsArray()
    {
        $result = parent::find()
            ->select(['id', 'name_ru as name'])
            ->all();
        return ArrayHelper::map($result, 'id', 'name');
    }

    public static function createFromNameString(string $name)
    {
        if(strpos($name, '(') !== false) {
            list($nameRu, $nameEn) = explode('(', trim($name));
            $nameEn = trim($nameEn, '()');
        } else {
            $nameRu = $name;
            $nameEn = $name;
        }
        $nameRu = trim($nameRu);
        $nameEn = trim($nameEn);

        $query = parent::find()
            ->where(['name_ru' => $nameRu])
            ->orWhere(['name_en' => $nameEn]);
        $model = $query->one();
        if(!$model) {
            $model = new self();
            $model->name_ru = $nameRu;
            $model->name_en = $nameEn;
            $model->save();
        }
        return $model;
    }

    public function getLinkedGenesIds()
    {
        return $this->getGeneToLongevityEffects()
            ->select('gene_id')->distinct()->column();
    }

}
