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

    public static function createFromNameString(string $name, $params = [])
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
            ->where(array_merge(['name_ru' => $nameRu], $params));
        if($nameEn) {
            $query->orWhere(array_merge(['name_en' => $nameEn], $params));
        }
        $model = $query->one();
        if(!$model) {
            $model = new self();
            $model->name_ru = $nameRu;
            $model->name_en = $nameEn;
            foreach ($params as $key => $value) {
                $model->$key = $value;
            }
            $model->save();
        }
        return $model;
    }

    public static function createNewByIds($ids)
    {
        if (!empty($ids) && is_array($ids)) {
            foreach ($ids as $id) {
                if (is_numeric($id)) {
                    continue;
                }
                self::createFromNameString($id);
            }
        }
    }

}