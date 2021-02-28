<?php


namespace cms\models\traits;


use yii\helpers\ArrayHelper;

trait RuEnActiveRecordTrait
{

    public static function getAllNamesAsArray()
    {
        $result = parent::find()
            ->select(['id', 'concat(name_ru, \' \', \'(\', name_en, \')\') as name'])
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
            $nameEn = null;
        }
        $nameRu = trim($nameRu);
        $nameEn = trim($nameEn);

        $query = parent::find()
            ->where(['name_ru' => $nameRu]);
        if($nameEn) {
            $query->orWhere(['name_en' => $nameEn]);
        }
        $model = $query->one();
        if(!$model) {
            $model = new self();
            $model->name_ru = $nameRu;
            $model->name_en = $nameEn;
            $model->save();
        }
        return $model;
    }
}