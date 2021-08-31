<?php


namespace app\models\traits;


use yii\helpers\ArrayHelper;

trait RuEnActiveRecordTrait
{

    public static function getAllNamesAsArray()
    {
        $names = self::find()
            ->select(['id', 'name_ru', 'name_en'])
            ->asArray()
            ->all();
        $result = [];
        foreach ($names as $name) {
            $result[$name['id']] = "{$name['name_ru']} ({$name['name_en']})";
        }
        return $result;
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